<?php

namespace App\Repository\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class RangeFilter implements FilterInterface
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
        $from = $filter['value']['from'] ?? (new $this->model())->min($filter['field']);
        $to = $filter['value']['to']  ?? (new $this->model())->max($filter['field']);

        $query->whereBetween($filter['field'], [is_numeric($from) ? (double)$from : $from, is_numeric($to) ? (double)$to : $to]);
    }

    public function validateFilter(): void
    {
        $model = $this->getModel();
        $filter = $this->getFilter();

        $newModelInstance = new $model();

        if (!$newModelInstance->getConnection()->getSchemaBuilder()->hasColumn($newModelInstance->getTable(), $filter['field'])) {
            throw new \Exception(sprintf("Model %s does not have field named as %s", $model, $filter['field']));
        }
    }

    public function getFilter(): array
    {
        return $this->filter;
    }

    public function setFilter(array $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        if (is_null($model)) {
            throw new \Exception("RangeFilter requires a model path. But received null instead.");
        }

        $this->model = $model;

        return $this;
    }
}
