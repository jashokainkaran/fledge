<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'employer';

    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'password',
        'status',      // ← add this
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function jobs()
    {
        // 'employer_id' is the foreign key on the jobs table
        return $this->hasMany(Job::class, 'employer_id');
    }
}
