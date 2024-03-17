<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TariffModule extends Model
{
    protected $fillable = ['tariff_id', 'name', 'code'];

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
