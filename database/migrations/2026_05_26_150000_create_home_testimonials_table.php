<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('section_label')->nullable()->default('Testimonials And Success Stories');
            $table->string('section_title')->nullable()->default('What Our Students Say');
            $table->text('section_subtitle')->nullable();
            $table->json('testimonials')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_testimonials');
    }
};
