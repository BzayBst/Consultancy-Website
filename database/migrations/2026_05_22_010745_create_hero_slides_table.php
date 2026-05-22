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
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable();           // "Building Bright Futures..."
            $table->string('title_line1')->nullable();     // "Shaping Educational"
            $table->string('title_line2')->nullable();     // "And Career"
            $table->string('title_highlight')->nullable(); // "Dreams"  (rendered in <span class="highlight">)
            $table->string('title_line3')->nullable();     // "With HASU"
            $table->string('description')->nullable();
            // Features — stored as JSON array of {icon, label}
            $table->json('features')->nullable();
            // Buttons
            $table->string('btn_primary_label')->nullable();
            $table->string('btn_primary_href')->nullable();
            $table->string('btn_ghost_label')->nullable();
            $table->string('btn_ghost_href')->nullable();
            // Visual
            $table->string('image_path')->nullable();     // stored path or external URL
            $table->string('image_alt')->nullable();
            $table->string('plane_emoji')->nullable()->default('✈️');
            // State
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
