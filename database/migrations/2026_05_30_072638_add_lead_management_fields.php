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
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->string('status')->default('new')->after('is_read');
            $table->text('internal_notes')->nullable()->after('status');
        });
 
        Schema::table('appointment_submissions', function (Blueprint $table) {
            $table->string('status')->default('new')->after('is_read');
            $table->text('internal_notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropColumn(['status', 'internal_notes']);
        });
 
        Schema::table('appointment_submissions', function (Blueprint $table) {
            $table->dropColumn(['status', 'internal_notes']);
        });
    }
};
