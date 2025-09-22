<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $table = 'otps';
    protected $fillable = [
        'user_id', 'otp', 'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];
}
