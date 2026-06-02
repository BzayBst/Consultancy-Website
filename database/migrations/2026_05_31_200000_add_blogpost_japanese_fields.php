<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('blog_posts')) {
            return;
        }

        // Add columns only if original exists and the _ja variant is missing
        if (Schema::hasColumn('blog_posts', 'title') && ! Schema::hasColumn('blog_posts', 'title_ja')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->string('title_ja')->nullable()->after('title');
            });
        }

        if (Schema::hasColumn('blog_posts', 'excerpt') && ! Schema::hasColumn('blog_posts', 'excerpt_ja')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->text('excerpt_ja')->nullable()->after('excerpt');
            });
        }

        if (Schema::hasColumn('blog_posts', 'content') && ! Schema::hasColumn('blog_posts', 'content_ja')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->longText('content_ja')->nullable()->after('content');
            });
        }

        if (Schema::hasColumn('blog_posts', 'image_alt') && ! Schema::hasColumn('blog_posts', 'image_alt_ja')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->string('image_alt_ja')->nullable()->after('image_alt');
            });
        }

        if (Schema::hasColumn('blog_posts', 'meta_title') && ! Schema::hasColumn('blog_posts', 'meta_title_ja')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->string('meta_title_ja')->nullable()->after('meta_title');
            });
        }

        if (Schema::hasColumn('blog_posts', 'meta_description') && ! Schema::hasColumn('blog_posts', 'meta_description_ja')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->string('meta_description_ja')->nullable()->after('meta_description');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('blog_posts')) {
            return;
        }

        Schema::table('blog_posts', function (Blueprint $table) {
            if (Schema::hasColumn('blog_posts', 'title_ja')) $table->dropColumn('title_ja');
            if (Schema::hasColumn('blog_posts', 'excerpt_ja')) $table->dropColumn('excerpt_ja');
            if (Schema::hasColumn('blog_posts', 'content_ja')) $table->dropColumn('content_ja');
            if (Schema::hasColumn('blog_posts', 'image_alt_ja')) $table->dropColumn('image_alt_ja');
            if (Schema::hasColumn('blog_posts', 'meta_title_ja')) $table->dropColumn('meta_title_ja');
            if (Schema::hasColumn('blog_posts', 'meta_description_ja')) $table->dropColumn('meta_description_ja');
        });
    }
};
