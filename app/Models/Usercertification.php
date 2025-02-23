<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCertification extends Model
{
    protected $table = 'usercertifications';
    
    protected $fillable = [
        'userid',  // Make sure this matches the column name
        'name',
        'file',
        'organization',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');  // Specify the correct foreign key
    }
}