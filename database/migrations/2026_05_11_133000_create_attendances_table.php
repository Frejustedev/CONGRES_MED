<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->foreignId('session_id')->nullable()->constrained('program_sessions')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('scanned_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('scan_point', 32)->default('entrance'); // entrance|room|exit|gala|workshop
            $table->dateTime('scanned_at');
            $table->ipAddress('scanner_ip')->nullable();
            $table->string('scanner_device')->nullable(); // user-agent court
            $table->boolean('is_offline_sync')->default(false); // scan offline puis sync
            $table->string('sync_uuid', 36)->nullable(); // pour dedup PWA offline
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['registration_id', 'scanned_at']);
            $table->index(['session_id', 'scanned_at']);
            $table->index('scan_point');
            $table->unique('sync_uuid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
