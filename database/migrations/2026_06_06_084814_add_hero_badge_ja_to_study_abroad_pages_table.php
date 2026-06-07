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
        Schema::table('study_abroad_pages', function (Blueprint $table) {
            $table->string('hero_badge_ja')->nullable()->after('hero_badge');
        });
    }

    public function down(): void
    {
        Schema::table('study_abroad_pages', function (Blueprint $table) {
            $table->dropColumn('hero_badge_ja');
        });
    }
};
