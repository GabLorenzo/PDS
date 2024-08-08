<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['username', 'password'];

    protected $hidden = ['password'];

    public function personalInfo(): HasOne
    {
        return $this->hasOne(PersonalInfo::class, 'username', 'username');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'username');
    }
    public function family()
    {
        return $this->hasMany(Family::class, 'user_id', 'username');
    }
    public function educationBackgrounds(): HasMany
    {
        return $this->hasMany(EducationBackground::class, 'user_id', 'username');
    }
    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class, 'username', 'username');
    }
    public function awards(): HasMany
    {
        return $this->hasMany(Award::class, 'username', 'username');
    }
}
