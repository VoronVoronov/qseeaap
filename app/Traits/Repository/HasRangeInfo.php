<?php

namespace App\Traits\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait HasRangeInfo
{
    public function getTable(): string
    {
        $model = new (self::getModel());

        return $model?->getTable();
    }

    public function getRangeInfo(): array
    {
        $columns = Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns($this->getTable());

        $columns = $this->removeExtraColumns($columns);

        $select = [];

        foreach($columns as $field => $column) {
            if(!in_array($column->getType()->getName(), ['string', 'text', 'longtext', 'shorttext', 'tinyint'])) {
                $select[] = $column->getName();
            }
        }

        [$maxRangeQuery, $minRangeQuery] = $this->buildRangeQuery($select);

        return [
            '_max_values' => $maxRangeQuery->first()->toArray(),
            '_min_values' => $minRangeQuery->first()->toArray()
        ];
    }

    public function buildRangeQuery($array): array
    {
        $max = (new (self::getModel()))->query();
        $min = $max->clone();

        foreach($array as $key => $column) {
            $max->addSelect(DB::raw(sprintf('max(%s) as max_%s', $column, $column)));
            $min->addSelect(DB::raw(sprintf('min(%s) as min_%s', $column, $column)));
        }

        return [
            $max, $min
        ];
    }

    public function removeExtraColumns($array): array
    {
        $nominatedToCheck = Arr::except($array, ['id', 'status', 'created_at', 'updated_at']);

        $output = [];

        foreach($nominatedToCheck as $field => $column) {
            if(!Str::endsWith($field, '_id')) {
                $output[] = $column;
            }
        }

        return $output;
    }
}
