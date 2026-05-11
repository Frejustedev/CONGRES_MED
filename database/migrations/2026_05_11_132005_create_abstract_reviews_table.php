<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abstract_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('abstract_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('status', 24)->default('assigned'); // assigned|in_progress|submitted|declined|expired
            $table->dateTime('assigned_at');
            $table->dateTime('due_at')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('declined_at')->nullable();
            $table->text('decline_reason')->nullable();

            // Scoring multicritères (1-10)
            $table->tinyInteger('score_originality')->nullable();
            $table->tinyInteger('score_methodology')->nullable();
            $table->tinyInteger('score_relevance')->nullable();
            $table->tinyInteger('score_clarity')->nullable();
            $table->tinyInteger('score_overall')->nullable();
            $table->decimal('weighted_score', 5, 2)->nullable();

            // Recommandation
            $table->string('recommendation', 24)->nullable(); // accept|accept_minor|accept_major|reject|undecided

            // Commentaires
            $table->longText('comments_to_authors')->nullable();
            $table->longText('comments_to_editors')->nullable(); // confidentiel
            $table->boolean('conflict_declared')->default(false);
            $table->text('conflict_description')->nullable();

            // Double-blind anonymisation
            $table->string('anonymous_name')->nullable(); // "Reviewer #1"

            $table->timestamps();

            $table->unique(['abstract_id', 'reviewer_user_id']);
            $table->index('status');
            $table->index('recommendation');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abstract_reviews');
    }
};
