<?php

namespace App\Interfaces\CRUD;

interface DeleteInterface
{
    /*
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
