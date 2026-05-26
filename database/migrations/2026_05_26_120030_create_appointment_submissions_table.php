<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('branch');
            $table->date('appointment_date');
            $table->string('appointment_time');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('education')->nullable();
            $table->string('destination')->nullable();
            $table->string('service')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_submissions');
    }
};
