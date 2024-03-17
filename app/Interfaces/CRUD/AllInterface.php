<?php

namespace App\Interfaces\CRUD;

use Illuminate\Database\Eloquent\Collection;

interface AllInterface
{
    /*
     * @param int $id
     * @return Collection
     */
    public function all(): Collection;
}
