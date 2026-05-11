<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abstract_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('abstract_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('salutation', 16)->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('affiliation');
            $table->string('country', 2)->nullable();
            $table->string('orcid')->nullable();
            $table->boolean('is_corresponding')->default(false);
            $table->boolean('is_presenter')->default(false);
            $table->integer('display_order')->default(0);
            $table->boolean('consent_given')->default(false);
            $table->timestamps();

            $table->index(['abstract_id', 'display_order']);
            $table->index('is_corresponding');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abstract_authors');
    }
};
