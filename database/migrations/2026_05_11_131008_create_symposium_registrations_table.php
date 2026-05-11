<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symposium_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('symposium_id')->constrained('symposiums')->cascadeOnDelete();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->string('status', 16)->default('pending'); // pending|paid|cancelled|attended
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->string('currency', 3)->default('XOF');
            $table->dateTime('attended_at')->nullable();
            $table->timestamps();

            $table->unique(['symposium_id', 'registration_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symposium_registrations');
    }
};
