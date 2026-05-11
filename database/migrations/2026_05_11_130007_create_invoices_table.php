<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique(); // CONG-INV-2026-00001
            $table->string('type', 16)->default('invoice'); // invoice|proforma|credit_note
            $table->nullableMorphs('billable'); // registration | group_registration | sponsor | exhibitor | symposium

            // Émetteur (figé au moment d'émission)
            $table->string('issuer_name');
            $table->string('issuer_address')->nullable();
            $table->string('issuer_vat_number')->nullable();
            $table->string('issuer_phone')->nullable();
            $table->string('issuer_email')->nullable();

            // Destinataire
            $table->string('buyer_name');
            $table->string('buyer_organization')->nullable();
            $table->string('buyer_address')->nullable();
            $table->string('buyer_city')->nullable();
            $table->string('buyer_country', 2)->nullable();
            $table->string('buyer_vat_number')->nullable();
            $table->string('buyer_email')->nullable();

            // Lignes facturées (snapshot)
            $table->json('lines'); // [{description, quantity, unit_price, total, vat_rate}]
            $table->decimal('subtotal_ht', 14, 2)->default(0);
            $table->decimal('vat_amount', 12, 2)->default(0);
            $table->decimal('vat_rate', 5, 2)->default(0);
            $table->decimal('total_ttc', 14, 2)->default(0);
            $table->string('currency', 3)->default('XOF');

            // États
            $table->string('status', 16)->default('issued'); // draft|issued|paid|cancelled|refunded
            $table->dateTime('issued_at');
            $table->dateTime('due_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();

            // Fichier généré
            $table->string('pdf_path')->nullable();
            $table->text('legal_mentions')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('issued_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
