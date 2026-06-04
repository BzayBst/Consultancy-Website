<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('core_values_sections', function (Blueprint $table) {
            if (! Schema::hasColumn('core_values_sections', 'section_label_ja')) {
                $table->string('section_label_ja', 80)->nullable()->after('section_label');
            }
            if (! Schema::hasColumn('core_values_sections', 'title_ja')) {
                $table->string('title_ja', 200)->nullable()->after('title');
            }
            if (! Schema::hasColumn('core_values_sections', 'subtitle_ja')) {
                $table->text('subtitle_ja')->nullable()->after('subtitle');
            }
        });

        Schema::table('core_values', function (Blueprint $table) {
            if (! Schema::hasColumn('core_values', 'title_ja')) {
                $table->string('title_ja', 100)->nullable()->after('title');
            }
            if (! Schema::hasColumn('core_values', 'description_ja')) {
                $table->text('description_ja')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('core_values_sections', function (Blueprint $table) {
            if (Schema::hasColumn('core_values_sections', 'subtitle_ja')) {
                $table->dropColumn(['section_label_ja', 'title_ja', 'subtitle_ja']);
            }
        });

        Schema::table('core_values', function (Blueprint $table) {
            if (Schema::hasColumn('core_values', 'description_ja')) {
                $table->dropColumn(['title_ja', 'description_ja']);
            }
        });
    }
};