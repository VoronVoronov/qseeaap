<?php

namespace App\Repository\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class MultipleValueRelation implements FilterInterface
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

        if ($this->isRelationFilter($filter)) {
            $query->whereHas($filter['relation'], function ($subQuery) use ($filter) {
                $this->applyRelationFilter($subQuery, $filter);
            });
        } else {
            $query->whereIn($filter['field'], $filter['value']);
        }
    }

    protected function applyRelationFilter(Builder &$query, array $filter): void
    {
        if (isset($filter['search']) && $filter['search']) {
            $query->where($filter['field'], 'LIKE', sprintf('%%%s%%', $filter['value']));
        } else {
            $query->where($filter['field'], $filter['value']);
        }
    }

    public function validateFilter(): void
    {
        $model = $this->getModel();
        $filter = $this->getFilter();

        $newModelInstance = new $model;

        if ($this->isRelationFilter($filter)) {
            $relation = $filter['relation'] ?? null;

            if (is_null($relation)) {
                throw new \Exception(sprintf("Expected relation name in filter[%s][relation], but got null", $filter['_key']));
            }

            try {
                $newModelInstance->whereHas($relation)->get();
            } catch (\Exception $e) {
                throw new \Exception(sprintf("Model %s does not have relation named as `%s`", $model, $relation));
            }
        } else {
            if (!$newModelInstance->getConnection()->getSchemaBuilder()->hasColumn($newModelInstance->getTable(), $filter['field'])) {
                throw new \Exception(sprintf("Model %s does not have a field named as %s", $model, $filter['field']));
            }

            if (!$this->isOneDimension($filter['value'])) {
                throw new \Exception(sprintf("Invalid value format. Expects one-dimensional array, but got a multi-dimensional array in filter[%s][value] field", $filter['field']));
            }
        }
    }

    protected function isRelationFilter(array $filter): bool
    {
        return isset($filter['relation']);
    }

    protected function isOneDimension(array $array): bool
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                return false;
            }
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
            throw new \Exception("MultipleValueRelationFilter requires a model path. But received null instead.");
        }

        $this->model = $model;

        return $this;
    }
}
