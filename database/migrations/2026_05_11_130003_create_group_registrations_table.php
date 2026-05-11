<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('organization_name');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_country', 2)->nullable();
            $table->string('vat_number')->nullable();
            $table->integer('expected_count')->default(1);
            $table->integer('confirmed_count')->default(0);
            $table->string('status', 24)->default('pending'); // pending|confirmed|invoiced|paid|cancelled
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->string('currency', 3)->default('XOF');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_registrations');
    }
};
