<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'industry',
        'company_description',
        'job_title',
        'city',
        'area',
        'pin_code',
        'street_address',
        'job_types',
        'schedules',
        'recruitment_timeline',
        'people_required',
        'job_description',
    ];

    protected $casts = [
        'job_types' => 'array',
        'schedules' => 'array',
    ];
}
