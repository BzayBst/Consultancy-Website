<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('course_pages')) {
            return;
        }

        Schema::table('course_pages', function (Blueprint $table) {
            if (! Schema::hasColumn('course_pages', 'stats_ja')) {
                $table->json('stats_ja')->nullable()->after('stats');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('course_pages')) {
            return;
        }

        Schema::table('course_pages', function (Blueprint $table) {
            if (Schema::hasColumn('course_pages', 'stats_ja')) {
                $table->dropColumn('stats_ja');
            }
        });
    }
};
