<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolReview extends Model
{
    use HasFactory;

    protected $table = 'school_reviews';
    protected $guarded =[];

    public function university()
    {
        return $this->belongsTo(University::class, 'school_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
