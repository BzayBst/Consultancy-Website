<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_badge')->nullable();
            $table->string('hero_title')->default('Language & Test Prep');
            $table->string('hero_highlight')->nullable()->default('Courses');
            $table->text('hero_subtitle')->nullable();
            $table->string('intro_label')->nullable();
            $table->string('intro_title')->nullable();
            $table->text('intro_subtitle')->nullable();
            $table->json('stats')->nullable();
            $table->string('catalog_label')->nullable();
            $table->string('catalog_title')->nullable();
            $table->string('why_label')->nullable();
            $table->string('why_title')->nullable();
            $table->text('why_description')->nullable();
            $table->json('why_items')->nullable();
            $table->string('cta_title')->nullable();
            $table->text('cta_subtitle')->nullable();
            $table->string('cta_button_label')->nullable();
            $table->string('cta_button_url')->nullable();
            $table->string('cta_phone_label')->nullable();
            $table->string('cta_phone_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_pages');
    }
};
