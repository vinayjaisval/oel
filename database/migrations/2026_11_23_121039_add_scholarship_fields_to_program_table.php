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
        Schema::table('program', function (Blueprint $table) {
            $table->boolean('scholarship_available')->default(0)->after('scholarships');
            $table->string('scholarship_name')->nullable()->after('scholarship_available');
            $table->decimal('scholarship_amount', 12, 2)->nullable()->after('scholarship_name');
            $table->string('scholarship_currency', 10)->nullable()->after('scholarship_amount');
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
            $table->dropColumn(['scholarship_available', 'scholarship_name', 'scholarship_amount', 'scholarship_currency']);
        });
    }
};
