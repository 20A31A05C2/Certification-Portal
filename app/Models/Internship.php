<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'name',
        'organization',
        'description',
        'link',
        'end_date'
    ];

    protected $casts = [
        'end_date' => 'date'
    ];
}