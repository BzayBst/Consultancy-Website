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
        Schema::create('about_stats', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20);    // e.g. "11"
            $table->string('accent', 5);     // e.g. "+" or "%"
            $table->string('label');         // e.g. "Years of Experience"
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_stats');
    }
};
