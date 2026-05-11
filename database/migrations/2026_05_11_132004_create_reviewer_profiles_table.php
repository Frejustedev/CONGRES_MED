<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviewer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->json('expertise_areas')->nullable(); // ids thematic_areas
            $table->json('keywords')->nullable();
            $table->integer('max_assignments')->default(5);
            $table->integer('current_load')->default(0);
            $table->integer('completed_count')->default(0);
            $table->integer('average_turnaround_days')->nullable();
            $table->json('conflicts_of_interest')->nullable(); // ['author_email', 'institution_name']
            $table->boolean('is_available')->default(true);
            $table->dateTime('available_from')->nullable();
            $table->dateTime('available_until')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('is_available');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviewer_profiles');
    }
};
