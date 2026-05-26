<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location_label')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('weekday_hours')->nullable();
            $table->string('saturday_hours')->nullable();
            $table->text('map_embed_url')->nullable();
            $table->string('map_link_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_offices');
    }
};
