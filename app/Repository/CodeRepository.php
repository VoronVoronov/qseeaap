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
        return Code::where('phone', $phone)
            ->where('is_used', 0)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function create(array $data)
    {
        Code::where('phone', $data['phone'])
            ->where('action', 'register')
            ->where('is_used', 0)
            ->update(['is_used' => 1]);
        return parent::create($data);
    }
}
