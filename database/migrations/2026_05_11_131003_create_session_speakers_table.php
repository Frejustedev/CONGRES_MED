<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('session_speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('program_sessions')->cascadeOnDelete();
            $table->foreignId('speaker_id')->constrained()->cascadeOnDelete();
            $table->string('role', 24)->default('speaker'); // chair|moderator|speaker|panelist|invited|opener|closer
            $table->string('talk_title')->nullable();
            $table->text('talk_abstract')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->unique(['session_id', 'speaker_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_speakers');
    }
};
