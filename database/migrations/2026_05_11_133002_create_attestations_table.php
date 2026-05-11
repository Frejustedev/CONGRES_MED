<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attestations', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('registration_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('speaker_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('reviewer_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type', 24); // attendance|cme|speaker|reviewer|chair
            $table->string('recipient_name');
            $table->string('recipient_email')->nullable();
            $table->json('included_sessions')->nullable(); // pour CME : liste sessions suivies
            $table->decimal('total_credits', 6, 2)->default(0);
            $table->string('pdf_path')->nullable();
            $table->string('verification_code', 32)->unique(); // pour la page de vérif publique
            $table->dateTime('issued_at');
            $table->dateTime('downloaded_at')->nullable();
            $table->integer('download_count')->default(0);
            $table->dateTime('revoked_at')->nullable();
            $table->text('revocation_reason')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->index('issued_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attestations');
    }
};
