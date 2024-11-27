<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @method static where(string $string, int $int)
 */
class Tariff extends Model
{
    use HasTranslations;
    public $translatable = ['name'];

    protected $fillable = ['name', 'price_one_month', 'price_three_month', 'price_six_month', 'price_one_year', 'status'];

    public function access()
    {
        return $this->hasMany(TariffAccess::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'tariff_menus');
    }
}
