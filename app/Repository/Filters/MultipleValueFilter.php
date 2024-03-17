<?php

namespace App\Repository\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class MultipleValueFilter implements FilterInterface
{
    public array $filter = [];

    public ?string $model;

    public function __construct(?string $model)
    {
        $this->setModel($model);
    }

    public function applyFilter(Builder &$query): void
    {
        $this->validateFilter();

        $filter = $this->getFilter();

        $query->whereIn($filter['field'], $filter['value']);
    }

    public function validateFilter(): void
    {
        $model = $this->getModel();
        $filter = $this->getFilter();

        $newModelInstance = new $model();

        if (!$newModelInstance->getConnection()->getSchemaBuilder()->hasColumn($newModelInstance->getTable(), $filter['field'])) {
            throw new \Exception(sprintf("Model %s does not have field named as %s", $model, $filter['field']));
        }

        if (!$this->isOneDimension($filter['value'])) {
            throw new \Exception(sprintf("Invalid value format. Expects one-dimensional array, but got multi-dimensional array in filter[%s][value] field", $filter['field']));
        }
    }

    protected function isOneDimension(array $array): bool
    {
        foreach ($array as $value) {
            if (is_array($value)) return false;
        }

        return true;
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

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        if (is_null($model)) {
            throw new \Exception("MultipleValueFilter requires a model path. But received null instead.");
        }

        $this->model = $model;

        return $this;
    }
}
