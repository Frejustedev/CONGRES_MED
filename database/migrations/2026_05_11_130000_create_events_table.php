<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('theme')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('timezone', 64)->default('Africa/Porto-Novo');
            $table->string('venue_name')->nullable();
            $table->string('venue_address')->nullable();
            $table->string('venue_city')->nullable();
            $table->string('venue_country', 2)->nullable();
            $table->decimal('venue_latitude', 10, 7)->nullable();
            $table->decimal('venue_longitude', 10, 7)->nullable();
            $table->string('status', 24)->default('draft'); // draft|published|registration_open|registration_closed|live|ended|archived
            $table->dateTime('registration_opens_at')->nullable();
            $table->dateTime('registration_closes_at')->nullable();
            $table->dateTime('abstracts_open_at')->nullable();
            $table->dateTime('abstracts_close_at')->nullable();
            $table->integer('max_capacity')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
