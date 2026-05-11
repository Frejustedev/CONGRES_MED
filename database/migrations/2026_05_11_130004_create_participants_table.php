<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('salutation', 16)->nullable(); // Dr, Pr, M., Mme...
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('profession')->nullable();
            $table->string('organization')->nullable();
            $table->string('job_title')->nullable();
            $table->string('specialty')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country', 2)->nullable(); // ISO code
            $table->string('country_of_origin', 2)->nullable();
            $table->string('rpps_number')->nullable(); // numéro pro France
            $table->string('adeli_number')->nullable();
            $table->string('orcid')->nullable();
            $table->text('biography')->nullable();
            $table->string('avatar_path')->nullable();
            $table->json('dietary_restrictions')->nullable(); // ['halal','vegetarian','gluten_free']
            $table->json('accessibility_needs')->nullable();
            $table->string('preferred_locale', 8)->default('fr');
            $table->boolean('newsletter_optin')->default(false);
            $table->boolean('directory_optin')->default(false); // partage annuaire participants
            $table->timestamps();
            $table->softDeletes();

            $table->index('email');
            $table->index(['last_name', 'first_name']);
            $table->index('country');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
