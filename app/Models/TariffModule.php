<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TariffModule extends Model
{
    use HasTranslations;
    public $translatable = ['name'];
    protected $fillable = ['name', 'code'];

    public function access()
    {
        return $this->hasMany(TariffAccess::class);
    }
}
