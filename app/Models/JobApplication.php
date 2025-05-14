<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobApplication extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'student_id',    // singular
        'job_id',        // singular
        'cover_letter',
        'cv_path',
        'status',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * The student who made the application.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * The job this application refers to.
     */
 public function job()
{
    return $this->belongsTo(Job::class, 'job_id'); // ✅ correct key
}

    /**
     * The review associated with this application.
     */
    public function review()
    {
        return $this->hasOne(Review::class, 'application_id');
    }

    
}