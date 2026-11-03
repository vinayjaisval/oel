<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_shortlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 120);
            $table->timestamps();
            $table->index(['user_id', 'updated_at']);
        });

        Schema::create('program_shortlist_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shortlist_id')->constrained('program_shortlists')->cascadeOnDelete();
            $table->unsignedBigInteger('program_id');
            $table->timestamps();
            $table->unique(['shortlist_id', 'program_id']);
            $table->index('program_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_shortlist_program');
        Schema::dropIfExists('program_shortlists');
    }
};