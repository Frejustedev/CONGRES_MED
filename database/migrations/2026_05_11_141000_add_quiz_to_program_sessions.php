<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_sessions', function (Blueprint $table) {
            $table->json('quiz_questions')->nullable()->after('attachments');
            $table->boolean('quiz_required_for_cme')->default(false)->after('quiz_questions');
            $table->integer('quiz_pass_threshold')->default(70)->after('quiz_required_for_cme');
        });
    }

    public function down(): void
    {
        Schema::table('program_sessions', function (Blueprint $table) {
            $table->dropColumn(['quiz_questions', 'quiz_required_for_cme', 'quiz_pass_threshold']);
        });
    }
};
