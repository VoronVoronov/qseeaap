<?php

namespace App\Interfaces\CRUD;

interface ShowInterface
{
    /*
     * @param int $id
     * @return static|null
     */
    public function show(int $id);
}
