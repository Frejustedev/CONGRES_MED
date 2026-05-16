<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->string('category', 32)->default('announcement');
            $table->string('cover_image_path')->nullable();
            $table->string('cover_caption')->nullable();
            $table->json('tags')->nullable();
            $table->foreignId('author_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('author_display_name')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('allow_comments')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->integer('reading_time')->nullable();
            $table->string('locale', 8)->default('fr');
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_published');
            $table->index('category');
            $table->index(['is_featured', 'published_at']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
