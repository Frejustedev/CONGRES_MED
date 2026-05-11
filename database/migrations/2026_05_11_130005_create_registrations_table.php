<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // CONG-2026-00001
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('registration_categories');
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes')->nullOnDelete();
            $table->foreignId('group_registration_id')->nullable()->constrained('group_registrations')->nullOnDelete();

            // Tarif/paiement
            $table->decimal('amount_due', 12, 2)->default(0);
            $table->decimal('amount_discount', 12, 2)->default(0);
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->string('currency', 3)->default('XOF');
            $table->string('pricing_tier', 16)->default('standard'); // early_bird|standard|late

            // Add-ons (gala, atelier, excursion)
            $table->json('addons')->nullable();
            $table->decimal('addons_amount', 12, 2)->default(0);

            // Statut
            $table->string('status', 24)->default('pending'); // pending|awaiting_payment|confirmed|cancelled|refunded
            $table->string('source', 16)->default('online'); // online|on_site|imported|invited

            // Badge / QR
            $table->string('qr_token', 64)->unique();
            $table->boolean('badge_generated')->default(false);
            $table->dateTime('badge_generated_at')->nullable();
            $table->string('badge_path')->nullable();

            // Workflow Jour J
            $table->dateTime('checked_in_at')->nullable();
            $table->foreignId('checked_in_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Visa / accompagnant
            $table->boolean('visa_letter_requested')->default(false);
            $table->boolean('visa_letter_issued')->default(false);
            $table->string('visa_letter_path')->nullable();
            $table->integer('accompanying_persons')->default(0);

            // Dates clés
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();

            // Métadonnées
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('source');
            $table->index('checked_in_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
