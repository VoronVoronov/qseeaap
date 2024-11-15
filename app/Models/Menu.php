<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;
use Carbon\Carbon;

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
        if ($value) {
            $disk = Storage::disk('s3');
            $expiration = Carbon::now()->addMinutes(10); // Set the expiration time for the signed URL
            return $disk->temporaryUrl($value, $expiration);
        }

        return null;
    }

    public function getBannerAttribute($value)
    {
        if ($value) {
            $disk = Storage::disk('s3');
            $expiration = Carbon::now()->addMinutes(10); // Set the expiration time for the signed URL
            return $disk->temporaryUrl($value, $expiration);
        }

        return null;
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
