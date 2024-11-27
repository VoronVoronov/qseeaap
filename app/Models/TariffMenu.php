<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TariffMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'tariff_id',
        'menu_id',
        'no_deadline',
        'expired_at',
    ];

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
