<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationBackground extends Model
{
    protected $fillable = [
        'username',
        'degree',
        'institution',
        'address',
        'yearOfGraduation',
        'basicEducation',
        'highestLevel',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'username', 'username');
    }
}

