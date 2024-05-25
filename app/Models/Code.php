<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'code',
        'phone',
        'is_used',
        'sms_id',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

}
