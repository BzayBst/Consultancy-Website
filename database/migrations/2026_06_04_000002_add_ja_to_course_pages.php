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
            if (! Schema::hasColumn('course_pages', 'hero_badge_ja')) {
                $table->string('hero_badge_ja')->nullable()->after('hero_badge');
            }
            if (! Schema::hasColumn('course_pages', 'hero_title_ja')) {
                $table->string('hero_title_ja')->nullable()->after('hero_title');
            }
            if (! Schema::hasColumn('course_pages', 'hero_highlight_ja')) {
                $table->string('hero_highlight_ja')->nullable()->after('hero_highlight');
            }
            if (! Schema::hasColumn('course_pages', 'hero_subtitle_ja')) {
                $table->text('hero_subtitle_ja')->nullable()->after('hero_subtitle');
            }

            if (! Schema::hasColumn('course_pages', 'intro_label_ja')) {
                $table->string('intro_label_ja')->nullable()->after('intro_label');
            }
            if (! Schema::hasColumn('course_pages', 'intro_title_ja')) {
                $table->string('intro_title_ja')->nullable()->after('intro_title');
            }
            if (! Schema::hasColumn('course_pages', 'intro_subtitle_ja')) {
                $table->text('intro_subtitle_ja')->nullable()->after('intro_subtitle');
            }

            if (! Schema::hasColumn('course_pages', 'catalog_label_ja')) {
                $table->string('catalog_label_ja')->nullable()->after('catalog_label');
            }
            if (! Schema::hasColumn('course_pages', 'catalog_title_ja')) {
                $table->string('catalog_title_ja')->nullable()->after('catalog_title');
            }

            if (! Schema::hasColumn('course_pages', 'why_label_ja')) {
                $table->string('why_label_ja')->nullable()->after('why_label');
            }
            if (! Schema::hasColumn('course_pages', 'why_title_ja')) {
                $table->string('why_title_ja')->nullable()->after('why_title');
            }
            if (! Schema::hasColumn('course_pages', 'why_description_ja')) {
                $table->text('why_description_ja')->nullable()->after('why_description');
            }
            if (! Schema::hasColumn('course_pages', 'why_items_ja')) {
                $table->json('why_items_ja')->nullable()->after('why_items');
            }

            if (! Schema::hasColumn('course_pages', 'cta_title_ja')) {
                $table->string('cta_title_ja')->nullable()->after('cta_title');
            }
            if (! Schema::hasColumn('course_pages', 'cta_subtitle_ja')) {
                $table->text('cta_subtitle_ja')->nullable()->after('cta_subtitle');
            }
            if (! Schema::hasColumn('course_pages', 'cta_button_label_ja')) {
                $table->string('cta_button_label_ja')->nullable()->after('cta_button_label');
            }
            if (! Schema::hasColumn('course_pages', 'cta_phone_label_ja')) {
                $table->string('cta_phone_label_ja')->nullable()->after('cta_phone_label');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('course_pages')) {
            return;
        }

        Schema::table('course_pages', function (Blueprint $table) {
            $cols = [
                'hero_badge_ja', 'hero_title_ja', 'hero_highlight_ja', 'hero_subtitle_ja',
                'intro_label_ja', 'intro_title_ja', 'intro_subtitle_ja',
                'catalog_label_ja', 'catalog_title_ja',
                'why_label_ja', 'why_title_ja', 'why_description_ja', 'why_items_ja',
                'cta_title_ja', 'cta_subtitle_ja', 'cta_button_label_ja', 'cta_phone_label_ja',
            ];

            foreach ($cols as $col) {
                if (Schema::hasColumn('course_pages', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
