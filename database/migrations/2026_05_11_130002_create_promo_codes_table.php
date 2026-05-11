<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('label')->nullable();
            $table->string('type', 16); // percentage|fixed|free
            $table->decimal('value', 12, 2)->default(0); // % si percentage, FCFA si fixed, 0 si free
            $table->string('currency', 3)->default('XOF');
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_until')->nullable();
            $table->integer('max_uses')->nullable();
            $table->integer('current_uses')->default(0);
            $table->integer('max_uses_per_user')->default(1);
            $table->json('applicable_categories')->nullable(); // category_ids autorisées, null = toutes
            $table->json('metadata')->nullable(); // sponsor associé, motif, etc.
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('is_active');
            $table->index(['valid_from', 'valid_until']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
