<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('tier', 24); // platinum|gold|silver|bronze|partner|institutional|media
            $table->string('logo_path')->nullable();
            $table->string('logo_dark_path')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->decimal('amount_pledged', 14, 2)->default(0);
            $table->decimal('amount_paid', 14, 2)->default(0);
            $table->string('currency', 3)->default('XOF');
            $table->json('benefits')->nullable(); // ['logo_homepage','booth','symposium','gala_table']
            $table->json('social_links')->nullable();
            $table->integer('booth_visits')->default(0);
            $table->boolean('is_published')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('tier');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
