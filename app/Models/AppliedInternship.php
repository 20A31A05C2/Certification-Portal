<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppliedInternship extends Model 
{
    protected $fillable = [
        'userid',
        'name',
        'organization', 
        'end_date',    // Changed from enddate to end_date
        'status',
    ];

    protected $casts = [
        'end_date' => 'date',  // Changed from enddate to end_date
    ];
}