<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use HasTranslations;
    public $translatable = ['name', 'description', 'address', 'work_time'];

    protected $fillable = [
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

    protected $appends = ['tariff_id'];

    public function getLogoAttribute($value)
    {
        if ($value) {
            $disk = Storage::disk('s3');
            return $disk->url($value);
        }

        return null;
    }

    public function getBannerAttribute($value)
    {
        if ($value) {
            $disk = Storage::disk('s3');
            return $disk->url($value);
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tariffs()
    {
        return $this->belongsToMany(Tariff::class, 'tariff_menus');
    }

    public function getTariffIdAttribute()
    {
        return $this->tariffs()->latest('tariff_menus.created_at')->first()->id ?? null;
    }
}
