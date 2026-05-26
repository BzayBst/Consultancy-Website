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
        Schema::create('ventures', function (Blueprint $table) {
              $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();           // "Nepal's trusted study-abroad consultancy"
            $table->enum('category', ['education','language','business','innovation'])->default('education');
            $table->enum('status', ['flagship','active','new','coming_soon'])->default('active');
 
            // Branding
            $table->string('emoji')->default('🎓');          // displayed as logo
            $table->string('banner_gradient')->nullable();   // e.g. "135deg,#0d1560,#2952e3"
            $table->string('tag_label')->nullable();         // e.g. "Education · Est. 2013"
            $table->string('tag_color')->nullable();         // e.g. "#2952e3"
            $table->string('tag_bg')->nullable();            // e.g. "#e8edfd"
            $table->string('accent_color')->default('#2952e3');
 
            // Content
            $table->text('description')->nullable();         // short (card + hero subtitle)
            $table->longText('long_description')->nullable(); // full detail page body
            $table->json('highlights')->nullable();           // ["item 1","item 2"] — "What We Do"
            $table->string('section_title')->nullable();      // default "What We Do"
 
            // Meta
            $table->string('location')->nullable();
            $table->string('established')->nullable();        // "2013 · Registered 2015"
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website_url')->nullable();
            $table->string('primary_btn_label')->nullable();  // "Learn More →"
            $table->string('primary_btn_url')->nullable();
            $table->string('secondary_btn_label')->nullable();
            $table->string('secondary_btn_url')->nullable();
 
            // Image
            $table->string('banner_image')->nullable();      // hero image path
 
            // Flags
            $table->boolean('is_featured')->default(false);  // shown as big featured card
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('order')->default(0);
 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventures');
    }
};
