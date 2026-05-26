<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('Book Your Free Consultation');
            $table->string('hero_highlight')->nullable()->default('Free');
            $table->text('hero_subtitle')->nullable();
            $table->string('form_title')->nullable();
            $table->text('form_subtitle')->nullable();
            $table->string('faq_label')->nullable();
            $table->string('faq_title')->nullable();
            $table->text('faq_subtitle')->nullable();
            $table->string('cta_title')->nullable();
            $table->text('cta_subtitle')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_pages');
    }
};
