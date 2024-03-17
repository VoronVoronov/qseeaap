<?php

namespace App\Traits\Repository;

use App\Repository\Filters\FilterFactory;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    public array $filter = [];

    public function applyFilter(Builder &$query): void
    {
        foreach ($this->getFilter() as $key => $value) {
            if (is_array($value) && isset($value['type'])) {
                FilterFactory::makeFromType($query, $value['type'], array_merge($value, ['_key' => $key]), model: $this->getModel());
            } else if (is_array($value) && !isset($value['type'])) {
                throw new \Exception(sprintf("Expected value in filter[%s][type] field. But got null", $key));
            } else {
                FilterFactory::makeBase($query, $key, $value, model: $this->getModel());
            }
        }
    }

    public function getFilter(): array
    {
        return $this->filter ?? [];
    }

    public function setFilter(?array $filter): self
    {
        $this->filter = $filter ?? [];

        return $this;
    }

}
