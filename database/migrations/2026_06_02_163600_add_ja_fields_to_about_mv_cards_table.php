<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJaFieldsToAboutMvCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (! Schema::hasTable('about_mv_cards')) {
            return;
        }

        Schema::table('about_mv_cards', function (Blueprint $table) {
            if (! Schema::hasColumn('about_mv_cards', 'title_ja')) {
                $table->string('title_ja')->nullable()->after('title');
            }
            if (! Schema::hasColumn('about_mv_cards', 'body_ja')) {
                $table->text('body_ja')->nullable()->after('body');
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
        if (! Schema::hasTable('about_mv_cards')) {
            return;
        }

        Schema::table('about_mv_cards', function (Blueprint $table) {
            if (Schema::hasColumn('about_mv_cards', 'title_ja')) {
                $table->dropColumn('title_ja');
            }
            if (Schema::hasColumn('about_mv_cards', 'body_ja')) {
                $table->dropColumn('body_ja');
            }
        });
    }
}
