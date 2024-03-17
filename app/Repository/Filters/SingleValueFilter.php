<?php

namespace App\Repository\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class SingleValueFilter implements FilterInterface
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

        foreach ($this->getFilter() as $field => $value) {
            $query->where($field, $value);
        }
    }

    public function validateFilter(): void
    {
        $model = $this->getModel();
        $filter = $this->getFilter();

        $newModelInstance = new $model();
        $field = array_key_first($filter);

        if(!$newModelInstance->getConnection()->getSchemaBuilder()->hasColumn($newModelInstance->getTable(), $field)) {
            throw new \Exception(sprintf("Model %s does not have field named as `%s`", $model, $field));
        }

        if(count($filter) > 1) {
            throw new \Exception(sprintf("Expects 1 element in \$filter variable, but got %s", count($filter)));
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

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        if(is_null($model)) {
            throw new \Exception("SingleValueFilter requires a model path. But received null instead.");
        }

        $this->model = $model;

        return $this;
    }
}
