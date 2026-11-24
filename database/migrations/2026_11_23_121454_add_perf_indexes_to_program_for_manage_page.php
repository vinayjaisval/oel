<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // `name` is varchar(500) utf8mb4, too wide for a full-column index
        // (InnoDB's 1000-byte key limit), so index only a prefix.
        DB::statement('ALTER TABLE `program` ADD INDEX `program_name_index` (`name`(191))');

        Schema::table('program', function (Blueprint $table) {
            $table->index('school_id');
            $table->index('user_id');
            $table->index('updated_at');
            $table->index('scholarship_available');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program', function (Blueprint $table) {
            $table->dropIndex('program_name_index');
            $table->dropIndex(['school_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['scholarship_available']);
        });
    }
};
