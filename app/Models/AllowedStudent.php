<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowedStudent extends Model
{
    use HasFactory;

    protected $table = 'allowed_students'; // Optional if table name matches model name pluralized

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'is_registered',
    ];

    // Cast the `is_registered` field as boolean
    protected $casts = [
        'is_registered' => 'boolean',
    ];
}
