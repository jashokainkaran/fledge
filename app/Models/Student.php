<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'student_id',      // this is your own student number, not the FK
        'password',
        'profile_picture',
        'cv',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * All raw job applications (JobApplication models).
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'student_id');
    }

    /**
     * The jobs the student has applied to (via the pivot table).
     */
    public function appliedJobs()
    {
        return $this->belongsToMany(
            Job::class,
            'job_applications',   // pivot table name
            'student_id',         // FK on pivot for this model
            'job_id'              // FK on pivot for the related model
        )
        ->withPivot('id', 'status', 'cover_letter', 'cv_path', 'start_date', 'end_date', 'created_at')
        ->withTimestamps();
    }

    /**
     * All completed job applications (raw models, filtered).
     */
    public function completedJobs()
    {
        return $this->hasMany(JobApplication::class, 'student_id')
                    ->where('status', 'Completed');
    }

    /**
     * Reviews authored by this student.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'student_id');
    }
}