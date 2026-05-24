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
        Schema::create('why_us_sections', function (Blueprint $table) {
             $table->id();
            $table->string('section_label')->default('Why Choose HASU');
            $table->string('title')->default('Reasons Students Trust Us');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('badge_number')->nullable()->default('98%');
            $table->string('badge_label')->nullable()->default('Visa Success Rate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('why_us_sections');
    }
};
