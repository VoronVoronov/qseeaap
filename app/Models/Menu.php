<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = [
        'tariff_id',
        'user_id',
        'name',
        'slug',
        'description',
        'address',
        'mode',
        'work_time',
        'logo',
        'banner'
    ];

    public function getLogoAttribute($value)
    {
        return $value ? \Storage::disk('s3')->url($value) : null;
    }

    public function getBannerAttribute($value)
    {
        return $value ? \Storage::disk('s3')->url($value) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
