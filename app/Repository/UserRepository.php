<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Base\BaseRepository;
use Illuminate\Support\Facades\Hash;


class UserRepository extends BaseRepository
{
   public function getModel(): string
   {
       return User::class;
   }

   public function findByPhone(string $phone): ?User
   {
       return User::where('phone', $phone)->first();
   }

   public function create(array $data)
   {
        $data['password'] = Hash::isHashed($data['password']) ? $data['password'] : Hash::make($data['password']);
        $data['registered_at'] = now();
        $data['register_ip'] = request()->ip();
        return parent::create($data);
   }
}
