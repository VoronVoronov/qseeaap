<?php

namespace App\Repository\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter implements FilterInterface
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

        $query->where($filter['field'], 'LIKE', sprintf("%%%s%%", $filter['value']));
    }

    public function validateFilter(): void
    {
        $model = $this->getModel();
        $filter = $this->getFilter();

        $newModelInstance = new $model();
        $field = $filter['field'];

        if(!$newModelInstance->getConnection()->getSchemaBuilder()->hasColumn($newModelInstance->getTable(), $field)) {
            throw new \Exception(sprintf("Model %s does not have field named as `%s`", $model, $field));
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
            throw new \Exception("SearchFilter requires a model path. But received null instead.");
        }

        $this->model = $model;

        return $this;
    }
}
