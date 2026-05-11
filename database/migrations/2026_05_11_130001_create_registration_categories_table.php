<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // member, non-member, student, resident, sponsor, press, exempt
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('currency', 3)->default('XOF');
            $table->decimal('price_early_bird', 12, 2)->default(0);
            $table->decimal('price_standard', 12, 2)->default(0);
            $table->decimal('price_late', 12, 2)->default(0);
            $table->dateTime('early_bird_until')->nullable();
            $table->dateTime('standard_until')->nullable();
            $table->integer('capacity')->nullable(); // max inscrits dans cette catégorie
            $table->integer('current_count')->default(0);
            $table->json('included_addons')->nullable(); // ['gala_dinner', 'workshop_a']
            $table->boolean('requires_proof')->default(false); // étudiant, presse...
            $table->boolean('is_public')->default(true); // false = catégorie cachée (sponsor/exempt)
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('is_public');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_categories');
    }
};
