<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function applyFilter(Builder &$query): void;

    public function setFilter(array $filter): self;

    public function getFilter(): array;

    public function validateFilter(): void;
}
