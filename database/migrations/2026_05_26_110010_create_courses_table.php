<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('language');
            $table->string('badge')->nullable();
            $table->string('tag')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->text('overview')->nullable();
            $table->json('description')->nullable();
            $table->json('meta_items')->nullable();
            $table->json('highlights')->nullable();
            $table->string('sidebar_title')->nullable();
            $table->text('sidebar_subtitle')->nullable();
            $table->json('sidebar_items')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
