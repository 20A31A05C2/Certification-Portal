<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class VerificationTeamMember extends Authenticatable 
{
    protected $fillable = ['username', 'email', 'password', 'certifications', 'assigned_users'];
    
    protected $casts = [
        'certifications' => 'array',
        'assigned_users' => 'array'
    ];
}