<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    protected $table = 'personal_info';
    protected $fillable = [
        'username',
        'surname',
        'firstname',
        'middlename',
        'extname',
        'dob',
        'place_of_birth',
        'sex',
        'citizenship',
        'dual_type',
        'dual_country',
        'height',
        'weight',
        'blood_type',
        'civil_status',
        'email'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'username', 'username');
    }
}
