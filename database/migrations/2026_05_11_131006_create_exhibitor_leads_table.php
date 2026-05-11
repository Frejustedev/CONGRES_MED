<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exhibitor_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibitor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->foreignId('scanned_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('scanned_at');
            $table->string('booth_location')->nullable();
            $table->text('notes')->nullable();
            $table->json('interests')->nullable(); // tags produits
            $table->string('follow_up_status', 24)->default('new'); // new|contacted|qualified|won|lost
            $table->dateTime('follow_up_at')->nullable();
            $table->timestamps();

            $table->unique(['exhibitor_id', 'registration_id', 'scanned_at']);
            $table->index('follow_up_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibitor_leads');
    }
};
