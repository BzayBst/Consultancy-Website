<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('teams')) { return; }

        Schema::table('teams', function (Blueprint $table) {
            if (! Schema::hasColumn('teams', 'name_ja')) {
                $table->string('name_ja', 100)->nullable()->after('name');
            }
            if (! Schema::hasColumn('teams', 'designation_ja')) {
                $table->string('designation_ja', 100)->nullable()->after('designation');
            }
            if (! Schema::hasColumn('teams', 'bio_ja')) {
                $table->text('bio_ja')->nullable()->after('bio');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('teams')) { return; }

        Schema::table('teams', function (Blueprint $table) {
            if (Schema::hasColumn('teams', 'name_ja')) {
                $table->dropColumn('name_ja');
            }
            if (Schema::hasColumn('teams', 'designation_ja')) {
                $table->dropColumn('designation_ja');
            }
            if (Schema::hasColumn('teams', 'bio_ja')) {
                $table->dropColumn('bio_ja');
            }
        });
    }
};