<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignId('parent_session_id')->nullable()->constrained('program_sessions')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->string('type', 24); // plenary|workshop|oral|poster|symposium|keynote|break|ceremony
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('language', 8)->default('fr');
            $table->integer('capacity')->nullable();
            $table->integer('cme_credits')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->boolean('requires_registration')->default(false);
            $table->boolean('requires_separate_payment')->default(false);

            // Streaming
            $table->boolean('is_streamed')->default(false);
            $table->string('stream_provider', 16)->nullable(); // youtube|twitch|self_hosted
            $table->string('stream_url')->nullable();
            $table->string('stream_embed_code')->nullable();

            // Replay
            $table->string('video_url')->nullable();
            $table->dateTime('video_available_until')->nullable();

            // Assets pédagogiques
            $table->string('slides_path')->nullable();
            $table->json('attachments')->nullable();

            // Tags / thématiques
            $table->json('topics')->nullable();
            $table->json('tags')->nullable();

            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('starts_at');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_sessions');
    }
};
