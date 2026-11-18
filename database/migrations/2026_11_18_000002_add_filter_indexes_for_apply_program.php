<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('program', function (Blueprint $table) {
            $table->index(['is_approved', 'created_at']);
            $table->index('program_sub_level');
            $table->index('program_discipline');
            $table->index('program_subdiscipline');
            $table->index('other_exam');
        });

        // program_level_id, education_level_id, intake, and tution_fee already have
        // indexes from the legacy (non-migration) schema -- adding them again would
        // just duplicate index-maintenance cost for zero benefit.

        // work_experience is varchar(255) on a MyISAM table (max key length 1000
        // bytes); under utf8mb4 that's 1020 bytes, so a full-column index doesn't
        // fit. It's only ever used for exact-match filtering, so a prefix index is
        // sufficient and correct.
        DB::statement('ALTER TABLE `program` ADD INDEX `program_work_experience_index` (`work_experience`(191))');
    }

    public function down()
    {
        Schema::table('program', function (Blueprint $table) {
            $table->dropIndex(['is_approved', 'created_at']);
            $table->dropIndex(['program_sub_level']);
            $table->dropIndex(['program_discipline']);
            $table->dropIndex(['program_subdiscipline']);
            $table->dropIndex(['other_exam']);
            $table->dropIndex('program_work_experience_index');
        });
    }
};
