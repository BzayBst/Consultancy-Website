<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_abroad_destinations', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('slug')->unique();
            $table->string('flag')->nullable();
            $table->string('card_tag')->nullable();
            $table->string('card_title')->nullable();
            $table->text('card_description')->nullable();
            $table->string('card_image')->nullable();
            $table->text('overview')->nullable();
            $table->string('benefits_title')->nullable();
            $table->text('benefits_description')->nullable();
            $table->json('benefits')->nullable();
            $table->json('courses')->nullable();
            $table->text('scholarship_text')->nullable();
            $table->json('cities')->nullable();
            $table->json('universities')->nullable();
            $table->json('faqs')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_abroad_destinations');
    }
};
