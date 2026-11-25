<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_three_sixtee', function (Blueprint $table) {
            $table->text('portal_password')->nullable()->change();
        });
    }

    public function down(): void
    {
        throw new \RuntimeException('The password column cannot be narrowed safely without reviewing existing encrypted values.');
    }
};
