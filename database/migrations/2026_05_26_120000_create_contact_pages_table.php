<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('Get In Touch With HASU');
            $table->string('hero_highlight')->nullable()->default('Touch');
            $table->text('hero_subtitle')->nullable();
            $table->string('form_title')->nullable();
            $table->text('form_subtitle')->nullable();
            $table->string('branch_title')->nullable();
            $table->text('branch_subtitle')->nullable();
            $table->string('faq_label')->nullable();
            $table->string('faq_title')->nullable();
            $table->text('faq_subtitle')->nullable();
            $table->string('social_title')->nullable();
            $table->text('social_subtitle')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_pages');
    }
};
