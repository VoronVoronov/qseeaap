<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static where(string $string, mixed $user_id)
 */
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
