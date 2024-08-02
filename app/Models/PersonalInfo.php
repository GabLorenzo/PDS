<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    protected $table = 'personal_info';

    protected $fillable = [
        
        'surname',
        'firstname',
        'middlename',
        'extname',
        'dob',
        'placeOfBirth',
        'sex',
        'citizenship',
        'dualType',
        'dualCountry',
        'height',
        'weight',
        'bloodType',
        'civilStatus',
        'email',
        'stud_Id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'stud_Id', 'username');
    }
}
    