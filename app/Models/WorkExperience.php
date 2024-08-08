<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = [
        'username',
        'address',
        'contact',
        'inclusive_dates',
        'position_title',
        'department',
        'monthly_salary',
        'salary_grade',
        'appointment_status',
        'govt_service'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'username', 'username');
    }
}
