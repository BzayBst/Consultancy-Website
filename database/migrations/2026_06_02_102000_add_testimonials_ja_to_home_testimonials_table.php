<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('home_testimonials')) {
            return;
        }

        Schema::table('home_testimonials', function (Blueprint $table) {
            if (! Schema::hasColumn('home_testimonials', 'testimonials_ja')) {
                $table->json('testimonials_ja')->nullable()->after('testimonials');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('home_testimonials')) {
            return;
        }

        Schema::table('home_testimonials', function (Blueprint $table) {
            if (Schema::hasColumn('home_testimonials', 'testimonials_ja')) {
                $table->dropColumn('testimonials_ja');
            }
        });
    }
};
