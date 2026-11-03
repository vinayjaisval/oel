<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramEnglishRequired extends Model
{
    use HasFactory;
    protected $table = 'program_english_required';
    protected $guarded= [];

    public function proficiency(): BelongsTo
    {
        return $this->belongsTo(EngProficiencyLevel::class, 'type');
    }
}
