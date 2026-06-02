<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('home_abouts')) {
            return;
        }

        Schema::table('home_abouts', function (Blueprint $table) {
            if (Schema::hasColumn('home_abouts', 'image_alt') && ! Schema::hasColumn('home_abouts', 'image_alt_ja')) {
                $table->string('image_alt_ja')->nullable()->after('image_alt');
            }

            if (Schema::hasColumn('home_abouts', 'perks') && ! Schema::hasColumn('home_abouts', 'perks_ja')) {
                $table->json('perks_ja')->nullable()->after('perks');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('home_abouts')) {
            return;
        }

        Schema::table('home_abouts', function (Blueprint $table) {
            if (Schema::hasColumn('home_abouts', 'perks_ja')) {
                $table->dropColumn('perks_ja');
            }

            if (Schema::hasColumn('home_abouts', 'image_alt_ja')) {
                $table->dropColumn('image_alt_ja');
            }
        });
    }
};
