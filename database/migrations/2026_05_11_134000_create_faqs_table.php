<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('category', 64)->default('general');
            $table->string('question');
            $table->longText('answer');
            $table->string('locale', 8)->default('fr');
            $table->integer('display_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['category', 'display_order']);
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
