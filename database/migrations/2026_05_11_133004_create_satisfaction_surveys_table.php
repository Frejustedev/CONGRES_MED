<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satisfaction_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->nullable()->constrained()->nullOnDelete();
            $table->tinyInteger('nps_score')->nullable(); // 0-10
            $table->tinyInteger('overall_rating')->nullable(); // 1-5
            $table->tinyInteger('content_rating')->nullable();
            $table->tinyInteger('venue_rating')->nullable();
            $table->tinyInteger('organization_rating')->nullable();
            $table->tinyInteger('networking_rating')->nullable();
            $table->json('topics_of_interest_next_edition')->nullable();
            $table->text('positive_feedback')->nullable();
            $table->text('improvement_feedback')->nullable();
            $table->text('comments')->nullable();
            $table->boolean('would_recommend')->nullable();
            $table->boolean('would_return')->nullable();
            $table->dateTime('submitted_at');
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();

            $table->index('nps_score');
            $table->index('overall_rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satisfaction_surveys');
    }
};
