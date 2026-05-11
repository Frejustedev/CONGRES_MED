<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cme_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->foreignId('session_id')->nullable()->constrained('program_sessions')->nullOnDelete();
            $table->string('category', 24)->default('cme'); // cme|dpc|formation_continue
            $table->decimal('credits', 5, 2)->default(0);
            $table->boolean('quiz_required')->default(false);
            $table->boolean('quiz_passed')->default(false);
            $table->tinyInteger('quiz_score')->nullable();
            $table->dateTime('earned_at');
            $table->dateTime('quiz_attempted_at')->nullable();
            $table->json('quiz_answers')->nullable();
            $table->boolean('validated')->default(false);
            $table->foreignId('validated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['registration_id', 'category']);
            $table->unique(['registration_id', 'session_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cme_credits');
    }
};
