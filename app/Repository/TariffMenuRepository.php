<?php

namespace App\Repository;

use App\Models\TariffMenu;
use App\Repository\Base\BaseRepository;

class TariffMenuRepository extends BaseRepository
{
    public function getModel(): string
    {
        return TariffMenu::class;
    }
}
