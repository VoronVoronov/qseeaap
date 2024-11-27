<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TariffAccess extends Model
{
    use HasFactory;

    protected $fillable = ['tariff_id', 'tariff_module_id'];

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function module()
    {
        return $this->belongsTo(TariffModule::class);
    }
}
