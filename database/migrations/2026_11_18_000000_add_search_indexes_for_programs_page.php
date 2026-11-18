<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->index('country_id');
            $table->index('is_approved');
        });

        Schema::table('program', function (Blueprint $table) {
            $table->index('is_approved');
        });
    }

    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropIndex(['country_id']);
            $table->dropIndex(['is_approved']);
        });

        Schema::table('program', function (Blueprint $table) {
            $table->dropIndex(['is_approved']);
        });
    }
};
