<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $table = 'family'; // Make sure this matches your table name

    protected $fillable = [
        'user_id',
        'relation',
        'name',
        'age',
        'occupation',
        'contactNumber',
    ];
}
