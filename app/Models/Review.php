<?php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'student_id',
        'job_application_id',
        'rating',          // only rating
    ];


    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }
}