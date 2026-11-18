<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('program', function (Blueprint $table) {
            $table->index('grading_scheme_id');
        });

        Schema::table('program_english_required', function (Blueprint $table) {
            $table->index('program_id');
        });

        Schema::table('student', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('education_history', function (Blueprint $table) {
            $table->index('student_id');
        });

        Schema::table('school_attended', function (Blueprint $table) {
            $table->index('student_id');
        });

        Schema::table('additional_qualification', function (Blueprint $table) {
            $table->index('student_id');
        });

        Schema::table('test_scores', function (Blueprint $table) {
            $table->index('student_id');
        });
    }

    public function down()
    {
        Schema::table('program', function (Blueprint $table) {
            $table->dropIndex(['grading_scheme_id']);
        });

        Schema::table('program_english_required', function (Blueprint $table) {
            $table->dropIndex(['program_id']);
        });

        Schema::table('student', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('education_history', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
        });

        Schema::table('school_attended', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
        });

        Schema::table('additional_qualification', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
        });

        Schema::table('test_scores', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
        });
    }
};
