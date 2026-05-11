<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // registration.confirmed, abstract.accepted, payment.received, etc.
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('locale', 8)->default('fr');
            $table->string('subject');
            $table->longText('body_html');
            $table->longText('body_text')->nullable();
            $table->json('available_variables')->nullable(); // ['participant_name', 'event_name', ...]
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['key', 'locale']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
