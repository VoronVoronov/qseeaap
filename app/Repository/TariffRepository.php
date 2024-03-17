<?php

namespace App\Repository;

use App\Models\Tariff;
use App\Repository\Base\BaseRepository;

class TariffRepository extends BaseRepository
{
    public function getModel(): string
    {
        return Tariff::class;
    }

    public function active()
    {
        return Tariff::where('status', 1)->get();
    }
}
