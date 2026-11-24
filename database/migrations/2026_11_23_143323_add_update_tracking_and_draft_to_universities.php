<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->timestamp('last_verified_at')->nullable()->after('updated_at');
            $table->unsignedBigInteger('last_updated_by')->nullable()->after('last_verified_at');
            $table->tinyInteger('is_draft')->default(0)->after('last_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn(['last_verified_at', 'last_updated_by', 'is_draft']);
        });
    }
};
