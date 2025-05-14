<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'job_type',
        'working_hours',
        'location',
        'pay_rate',
        'description',
        'employer_id',
        'status',
    ];

   public function employer()
    {
        // Make sure you import App\Models\Employer at the top:
        return $this->belongsTo(\App\Models\Employer::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'job_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    
}
