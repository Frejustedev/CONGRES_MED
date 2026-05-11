<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->nullableMorphs('payable'); // registration | symposium_registration | invoice
            $table->string('gateway', 24); // kkiapay|stripe|bank_transfer|cash|on_site
            $table->string('gateway_reference')->nullable();
            $table->string('gateway_method')->nullable(); // mtn_momo|moov|wave|visa|mastercard|cash
            $table->decimal('amount', 14, 2);
            $table->decimal('fee', 12, 2)->default(0);
            $table->string('currency', 3)->default('XOF');
            $table->string('status', 24)->default('pending'); // pending|processing|completed|failed|refunded|partially_refunded
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('failed_at')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->decimal('refunded_amount', 14, 2)->default(0);
            $table->text('refund_reason')->nullable();
            $table->foreignId('received_by_user_id')->nullable()->constrained('users')->nullOnDelete(); // pour cash on-site
            $table->json('gateway_payload')->nullable(); // raw response webhook
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('gateway');
            $table->index('status');
            $table->index('paid_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
