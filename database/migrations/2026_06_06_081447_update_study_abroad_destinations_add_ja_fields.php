<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_abroad_destinations', function (Blueprint $table) {

            // ── Remove stale columns added in error ──────────────────────────
            // These were in the original model but are not used by the component.
            // Drop them only if they exist so the migration is safe to re-run.
            if (Schema::hasColumn('study_abroad_destinations', 'name_ja')) {
                $table->dropColumn('name_ja');
            }
            if (Schema::hasColumn('study_abroad_destinations', 'requirements_ja')) {
                $table->dropColumn('requirements_ja');
            }

            // ── New scalar Japanese fields ───────────────────────────────────
            // card_tag_ja sits right after card_tag
            if (! Schema::hasColumn('study_abroad_destinations', 'card_tag_ja')) {
                $table->string('card_tag_ja', 120)->nullable()->after('card_tag');
            }

            // ── Note on JSON columns ─────────────────────────────────────────
            // The following columns already exist as JSON/longText and store
            // their Japanese sub-fields inside the JSON structure itself, so
            // NO new database columns are required for:
            //
            //   benefits    → each item now has title_ja, description_ja
            //   courses     → each item now has tag_ja, title_ja, description_ja
            //   cities      → each item now has title_ja, description_ja
            //   universities → each item now has name_ja
            //   faqs        → each item now has question_ja, answer_ja
        });
    }

    public function down(): void
    {
        Schema::table('study_abroad_destinations', function (Blueprint $table) {
            $table->dropColumnIfExists('card_tag_ja');

            // Restore the columns we dropped (nullable so existing rows are safe)
            if (! Schema::hasColumn('study_abroad_destinations', 'name_ja')) {
                $table->string('name_ja')->nullable()->after('country');
            }
            if (! Schema::hasColumn('study_abroad_destinations', 'requirements_ja')) {
                $table->json('requirements_ja')->nullable();
            }
        });
    }
};