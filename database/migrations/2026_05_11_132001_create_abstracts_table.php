<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abstracts', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // ABS-2026-00001
            $table->foreignId('submitter_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('thematic_area_id')->nullable()->constrained('thematic_areas')->nullOnDelete();
            $table->string('submission_type', 24); // oral|poster|eposter|case_report
            $table->string('title');
            $table->string('short_title')->nullable();
            $table->string('language', 8)->default('fr');
            $table->json('keywords')->nullable();

            // Structure IMRAD
            $table->longText('introduction')->nullable();
            $table->longText('methods')->nullable();
            $table->longText('results')->nullable();
            $table->longText('discussion')->nullable();
            $table->longText('conclusion')->nullable();
            $table->longText('references_text')->nullable();
            $table->integer('word_count')->default(0);

            // Cas clinique alternative
            $table->boolean('is_case_report')->default(false);
            $table->longText('case_description')->nullable();

            // Conflits d'intérêts
            $table->boolean('has_conflict_of_interest')->default(false);
            $table->text('conflict_disclosure')->nullable();
            $table->boolean('funding_disclosed')->default(false);
            $table->text('funding_sources')->nullable();
            $table->boolean('ethical_approval')->default(false);
            $table->string('ethical_approval_number')->nullable();

            // Anti-doublon
            $table->string('content_hash', 64)->index();

            // Statut
            $table->string('status', 24)->default('draft'); // draft|submitted|under_review|revision_required|accepted|rejected|withdrawn
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('decision_at')->nullable();
            $table->text('decision_comments')->nullable();
            $table->foreignId('decided_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('revision_round')->default(0);

            // Publication
            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->string('doi')->nullable();
            $table->integer('booklet_page_number')->nullable();

            // Présentation
            $table->foreignId('assigned_session_id')->nullable()->constrained('program_sessions')->nullOnDelete();
            $table->dateTime('presentation_at')->nullable();

            // Best abstract / awards
            $table->boolean('is_award_candidate')->default(false);
            $table->boolean('award_winner')->default(false);
            $table->string('award_label')->nullable();

            // Statistiques
            $table->integer('reviewer_count')->default(0);
            $table->decimal('average_score', 4, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('submission_type');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abstracts');
    }
};
