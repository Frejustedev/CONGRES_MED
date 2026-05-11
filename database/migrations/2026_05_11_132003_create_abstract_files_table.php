<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abstract_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('abstract_id')->constrained()->cascadeOnDelete();
            $table->string('type', 24); // figure|table|supplementary|poster_pdf|video
            $table->string('label')->nullable();
            $table->text('caption')->nullable();
            $table->string('file_path');
            $table->string('mime_type', 64)->nullable();
            $table->unsignedBigInteger('size_bytes')->default(0);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abstract_files');
    }
};
