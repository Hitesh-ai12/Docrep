<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'phone_number',
'hospital_name',
        'hospital_location',
        'designation',
        'years_of_experience',
        'dob',
        'wedding_date',
        'location',
        'current_work_availability',
        'preferred_consultation_method',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
