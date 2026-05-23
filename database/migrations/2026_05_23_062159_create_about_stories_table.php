<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('about_stories', function (Blueprint $table) {
            $table->id();
            $table->string('image_path')->nullable();
            $table->string('float_badge_icon')->nullable()->default('🏆');
            $table->string('float_badge_title')->nullable();
            $table->string('float_badge_subtitle')->nullable();
            $table->string('section_label')->nullable()->default('Our Story');
            $table->string('section_title')->nullable();
            $table->text('paragraph_1')->nullable();
            $table->text('paragraph_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_stories');
    }
};
