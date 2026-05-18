<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add role to users table (if not exists)
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['user', 'mentor', 'admin'])->default('user')->after('email');
            });
        }

        // Add quiz type to quizzes table (if not exists)
        if (!Schema::hasColumn('quizzes', 'type')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->enum('type', ['pre_test', 'post_test', 'regular'])->default('regular')->after('course_id');
            });
        }

        // Add pre/post scores and status to user_progress table
        Schema::table('user_progress', function (Blueprint $table) {
            if (!Schema::hasColumn('user_progress', 'score_pre_test')) {
                $table->integer('score_pre_test')->nullable()->after('progress_percentage');
            }
            if (!Schema::hasColumn('user_progress', 'score_post_test')) {
                $table->integer('score_post_test')->nullable()->after('score_pre_test');
            }
            if (!Schema::hasColumn('user_progress', 'module_status')) {
                $table->enum('module_status', ['LOCKED', 'PRE_TEST_DONE', 'LEARNING', 'POST_TEST_DONE', 'COMPLETED'])
                      ->default('LOCKED')->after('score_post_test');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
        if (Schema::hasColumn('quizzes', 'type')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
        Schema::table('user_progress', function (Blueprint $table) {
            $cols = ['score_pre_test', 'score_post_test', 'module_status'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('user_progress', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
