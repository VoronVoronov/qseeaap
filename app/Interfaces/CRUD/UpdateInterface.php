<?php

namespace App\Interfaces\CRUD;

interface UpdateInterface
{
    /*
     * @param int $id
     * @param array $data
     * @return static
     */
    public function update(int $id, array $data);
}
