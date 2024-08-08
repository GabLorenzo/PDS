<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_type',
        'country',
        'province',
        'city',
        'barangay',
        'house_number',
        'zip_code'
    ];

    public function user()
    {
        return $this->belongsTo(Student::class, 'user_id', 'username');
    }
}
