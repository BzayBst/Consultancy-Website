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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->date('event_end_date')->nullable();
            $table->time('event_time')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'past'])->default('upcoming');
            $table->string('location')->nullable();
            $table->string('organizer')->nullable();
            $table->string('learn_more_url')->nullable();
            $table->string('image')->nullable();         // stored path
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
