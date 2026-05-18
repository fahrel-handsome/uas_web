<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            if (!Schema::hasColumn('modules', 'content')) {
                $table->longText('content')->nullable()->after('description');
            }
            if (!Schema::hasColumn('modules', 'youtube_link')) {
                $table->string('youtube_link')->nullable()->after('content');
            }
            if (!Schema::hasColumn('modules', 'status')) {
                $table->enum('status', ['draft', 'published'])->default('draft')->after('youtube_link');
            }
        });

        // Add score_pre_test & score_post_test to user_progress if not exists
        Schema::table('user_progress', function (Blueprint $table) {
            if (!Schema::hasColumn('user_progress', 'module_id')) {
                $table->unsignedBigInteger('module_id')->nullable()->after('course_id');
                $table->foreign('module_id')->references('id')->on('modules')->onDelete('set null');
            }
            if (!Schema::hasColumn('user_progress', 'score_pre_test')) {
                $table->integer('score_pre_test')->nullable()->after('is_completed');
            }
            if (!Schema::hasColumn('user_progress', 'score_post_test')) {
                $table->integer('score_post_test')->nullable()->after('score_pre_test');
            }
            if (!Schema::hasColumn('user_progress', 'module_status')) {
                $table->enum('module_status', ['locked', 'in_progress', 'completed'])->default('locked')->after('score_post_test');
            }
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['content', 'youtube_link', 'status']);
        });
        Schema::table('user_progress', function (Blueprint $table) {
            $table->dropColumn(['module_id', 'score_pre_test', 'score_post_test', 'module_status']);
        });
    }
};
