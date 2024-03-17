<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, int $int)
 */
class Tariff extends Model
{
    protected $fillable = ['name', 'price', 'status'];

    public function modules()
    {
        return $this->hasMany(TariffModule::class);
    }
}
