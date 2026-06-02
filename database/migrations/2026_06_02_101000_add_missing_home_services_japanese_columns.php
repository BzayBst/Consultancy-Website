<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('home_services')) {
            return;
        }

        Schema::table('home_services', function (Blueprint $table) {
            if (! Schema::hasColumn('home_services', 'section_label_ja')) {
                $table->string('section_label_ja')->nullable()->after('section_label');
            }

            if (! Schema::hasColumn('home_services', 'section_title_ja')) {
                $table->string('section_title_ja')->nullable()->after('section_title');
            }

            if (! Schema::hasColumn('home_services', 'section_subtitle_ja')) {
                $table->text('section_subtitle_ja')->nullable()->after('section_subtitle');
            }

            if (! Schema::hasColumn('home_services', 'services_ja')) {
                $table->json('services_ja')->nullable()->after('services');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('home_services')) {
            return;
        }

        Schema::table('home_services', function (Blueprint $table) {
            foreach (['services_ja', 'section_subtitle_ja', 'section_title_ja', 'section_label_ja'] as $column) {
                if (Schema::hasColumn('home_services', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
