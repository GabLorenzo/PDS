<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = ['name', 'description', 'awardType', 'username'];  
    protected $primaryKey = 'id';

    public function student()
    {
        return $this->belongsTo(Student::class, 'username', 'username');
    }
}
