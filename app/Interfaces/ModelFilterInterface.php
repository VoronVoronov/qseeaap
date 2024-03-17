<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface  ModelFilterInterface
{
    public function applyFilter(Builder &$query): void;

    public function setFilter(array $filter): self;
}
