<?php

namespace App\Repository;

use App\Models\Code;
use App\Repository\Base\BaseRepository;

class CodeRepository extends BaseRepository
{
    public function getModel(): string
    {
        return Code::class;
    }

    public function getByPhone(string $phone)
    {
        return Code::where('phone', $phone)->latest()->first();
    }
}
