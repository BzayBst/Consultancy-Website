<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJaFieldsToAboutMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (! Schema::hasTable('about_milestones')) {
            return;
        }

        Schema::table('about_milestones', function (Blueprint $table) {
            if (! Schema::hasColumn('about_milestones', 'title_ja')) {
                $table->string('title_ja')->nullable()->after('title');
            }
            if (! Schema::hasColumn('about_milestones', 'description_ja')) {
                $table->text('description_ja')->nullable()->after('description');
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
        if (! Schema::hasTable('about_milestones')) {
            return;
        }

        Schema::table('about_milestones', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('about_milestones', 'title_ja')) {
                $cols[] = 'title_ja';
            }
            if (Schema::hasColumn('about_milestones', 'description_ja')) {
                $cols[] = 'description_ja';
            }

            if (count($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
}
