<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLabelJaToAboutStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (! Schema::hasTable('about_stats')) {
            return;
        }

        Schema::table('about_stats', function (Blueprint $table) {
            if (! Schema::hasColumn('about_stats', 'label_ja')) {
                $table->string('label_ja')->nullable()->after('label');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (! Schema::hasTable('about_stats')) {
            return;
        }

        Schema::table('about_stats', function (Blueprint $table) {
            if (Schema::hasColumn('about_stats', 'label_ja')) {
                $table->dropColumn('label_ja');
            }
        });
    }
}
