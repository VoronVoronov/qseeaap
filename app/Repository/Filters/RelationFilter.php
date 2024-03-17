<?php

namespace App\Repository\Filters;

use App\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RelationFilter implements FilterInterface
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

        $query->whereHas($filter['relation'], function($subQuery) use ($filter) {
            if(isset($filter['search']) && $filter['search']) {
                $subQuery->where($filter['field'], 'LIKE', sprintf('%%%s%%', $filter['value']));
            } else {
                $subQuery->where($filter['field'], $filter['value']);
            }
        });
    }

    public function validateFilter(): void
    {
        $model = $this->getModel();
        $filter = $this->getFilter();

        $newModelInstance = new $model();
        $relation = $filter['relation'] ?? null;

        if(is_null($relation)) {
            throw new \Exception(sprintf("Expected relation name in filter[%s][relation], but got null", $filter['_key']));
        }

        try {
            (new $model())->whereHas($relation)->get();
        } catch(\Exception $e) {
            throw new \Exception(sprintf("Model %s does not have relation named as `%s`", $model, $relation));
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
        if (is_null($model)) {
            throw new \Exception("RelationFilter requires a model path. But received null instead.");
        }

        $this->model = $model;

        return $this;
    }
}
