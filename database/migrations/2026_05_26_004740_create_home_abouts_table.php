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
        Schema::create('home_abouts', function (Blueprint $table) {
            $table->id();
            // ── Image & badge ─────────────────────────────────────────────
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable()->default('About HASU');
            $table->string('badge_number')->nullable()->default('11');
            $table->string('badge_label')->nullable()->default('Years of Experience');
 
            // ── Text ──────────────────────────────────────────────────────
            $table->string('section_label')->nullable()->default('About The Company');
            $table->string('section_title')->nullable()->default('Your Trusted Partner in Global Education');
            $table->text('paragraph_1')->nullable();
            $table->text('paragraph_2')->nullable();
 
            // ── Badges (icon + label chips) ───────────────────────────────
            $table->json('badges')->nullable();
            // [{"icon":"🏅","label":"Best Immigration Resources"}, ...]
 
            // ── Perks list ────────────────────────────────────────────────
            $table->json('perks')->nullable();
            // ["Offer 100% Genuine Assistance", ...]
 
            // ── CTA button ────────────────────────────────────────────────
            $table->string('cta_label')->nullable()->default('Know More');
            $table->string('cta_href')->nullable()->default('/about');
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_abouts');
    }
};
