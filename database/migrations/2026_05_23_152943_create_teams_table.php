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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('designation');          // e.g. "FOUNDER & CEO"
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();    // stored path
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->json('social_links')->nullable(); // { facebook, linkedin, twitter }
            $table->unsignedTinyInteger('order')->default(0); // display order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
