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
        if (! Schema::hasTable('ventures')) {
            return;
        }

        // Add nullable Japanese fields if they don't exist yet
        Schema::table('ventures', function (Blueprint $table) {
            if (! Schema::hasColumn('ventures', 'name_ja')) {
                $table->string('name_ja')->nullable()->after('name');
            }
            if (! Schema::hasColumn('ventures', 'tagline_ja')) {
                $table->string('tagline_ja')->nullable()->after('tagline');
            }
            if (! Schema::hasColumn('ventures', 'tag_label_ja')) {
                $table->string('tag_label_ja')->nullable()->after('tag_label');
            }
            if (! Schema::hasColumn('ventures', 'description_ja')) {
                $table->text('description_ja')->nullable()->after('description');
            }
            if (! Schema::hasColumn('ventures', 'long_description_ja')) {
                $table->longText('long_description_ja')->nullable()->after('long_description');
            }
            if (! Schema::hasColumn('ventures', 'highlights_ja')) {
                $table->json('highlights_ja')->nullable()->after('highlights');
            }
            if (! Schema::hasColumn('ventures', 'section_title_ja')) {
                $table->string('section_title_ja')->nullable()->after('section_title');
            }
            if (! Schema::hasColumn('ventures', 'primary_btn_label_ja')) {
                $table->string('primary_btn_label_ja')->nullable()->after('primary_btn_label');
            }
            if (! Schema::hasColumn('ventures', 'secondary_btn_label_ja')) {
                $table->string('secondary_btn_label_ja')->nullable()->after('secondary_btn_label');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('ventures')) {
            return;
        }

        Schema::table('ventures', function (Blueprint $table) {
            if (Schema::hasColumn('ventures', 'name_ja')) {
                $table->dropColumn('name_ja');
            }
            if (Schema::hasColumn('ventures', 'tagline_ja')) {
                $table->dropColumn('tagline_ja');
            }
            if (Schema::hasColumn('ventures', 'tag_label_ja')) {
                $table->dropColumn('tag_label_ja');
            }
            if (Schema::hasColumn('ventures', 'description_ja')) {
                $table->dropColumn('description_ja');
            }
            if (Schema::hasColumn('ventures', 'long_description_ja')) {
                $table->dropColumn('long_description_ja');
            }
            if (Schema::hasColumn('ventures', 'highlights_ja')) {
                $table->dropColumn('highlights_ja');
            }
            if (Schema::hasColumn('ventures', 'section_title_ja')) {
                $table->dropColumn('section_title_ja');
            }
            if (Schema::hasColumn('ventures', 'primary_btn_label_ja')) {
                $table->dropColumn('primary_btn_label_ja');
            }
            if (Schema::hasColumn('ventures', 'secondary_btn_label_ja')) {
                $table->dropColumn('secondary_btn_label_ja');
            }
        });
    }
};
