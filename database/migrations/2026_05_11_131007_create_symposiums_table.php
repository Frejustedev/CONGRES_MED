<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symposiums', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignId('sponsor_id')->nullable()->constrained('sponsors')->nullOnDelete();
            $table->foreignId('session_id')->nullable()->constrained('program_sessions')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->decimal('price', 12, 2)->default(0);
            $table->string('currency', 3)->default('XOF');
            $table->integer('capacity')->nullable();
            $table->integer('registered_count')->default(0);
            $table->boolean('requires_separate_registration')->default(true);
            $table->boolean('included_for_full_pass')->default(false);
            $table->string('cover_image_path')->nullable();
            $table->json('speakers_data')->nullable(); // [{name, title, affiliation}] (cache)
            $table->boolean('is_published')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_published');
            $table->index('starts_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symposiums');
    }
};
