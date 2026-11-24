<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolType extends Model
{
    protected $table = 'schooltype';
    protected $fillable = [
        'name', 'description', 'position', 'active'
    ];

    public function school()
    {
        return $this->hasMany(School::class, 'schooltype_id');
    }

    public function universities()
    {
        return $this->hasMany(University::class, 'type_of_university');
    }
}
