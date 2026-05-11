<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exhibitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained('sponsors')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('booth_number')->nullable();
            $table->string('booth_size')->nullable(); // 3x3, 6x3, custom
            $table->decimal('booth_x', 8, 2)->nullable(); // pour plan interactif
            $table->decimal('booth_y', 8, 2)->nullable();
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->json('staff_members')->nullable(); // [{name, role, email}]
            $table->json('attachments')->nullable(); // brochures, fiches techniques
            $table->json('product_tags')->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_published');
            $table->index('booth_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibitors');
    }
};
