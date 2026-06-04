<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJaColumnsToAboutStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('about_stories', function (Blueprint $table) {
            if (!Schema::hasColumn('about_stories', 'section_label_ja')) {
                $table->string('section_label_ja')->nullable();
            }
            if (!Schema::hasColumn('about_stories', 'paragraph_1_ja')) {
                $table->text('paragraph_1_ja')->nullable();
            }
            if (!Schema::hasColumn('about_stories', 'paragraph_2_ja')) {
                $table->text('paragraph_2_ja')->nullable();
            }
            if (!Schema::hasColumn('about_stories', 'float_badge_title_ja')) {
                $table->string('float_badge_title_ja')->nullable();
            }
            if (!Schema::hasColumn('about_stories', 'float_badge_subtitle_ja')) {
                $table->string('float_badge_subtitle_ja')->nullable();
            }
            if (!Schema::hasColumn('about_stories', 'section_title_ja')) {
                $table->string('section_title_ja')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('about_stories', function (Blueprint $table) {
            $cols = [
                'section_label_ja',
                'paragraph_1_ja',
                'paragraph_2_ja',
                'float_badge_title_ja',
                'float_badge_subtitle_ja',
                'section_title_ja',
            ];

            // Only drop columns that exist to avoid errors
            $existing = array_filter($cols, fn($c) => Schema::hasColumn('about_stories', $c));
            if (count($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
}
