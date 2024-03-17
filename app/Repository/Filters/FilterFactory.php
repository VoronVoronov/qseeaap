<?php

namespace App\Repository\Filters;

use Illuminate\Database\Eloquent\Builder;

final class FilterFactory
{
    protected static array $supportedFilters = [
        'single-value' => SingleValueFilter::class,
        'multiple-value' => MultipleValueFilter::class,
        'range' => RangeFilter::class,
        'relation' => RelationFilter::class,
        'search' => SearchFilter::class,
        'multiple-value-relation' => MultipleValueRelation::class,
    ];

    public static function makeFromType(Builder &$query, string $type, array $data, ?string $model = null): void
    {
        $filterClassString = self::$supportedFilters[$type] ?? null;

        if (is_null($filterClassString)) {
            throw new \Exception(sprintf("`%s` type is not supported", $type));
        }

        (new $filterClassString($model))->setFilter($data)->applyFilter($query);
    }

    public static function makeBase(Builder &$query, string $key, mixed $value, ?string $model = null): void
    {
        (new SingleValueFilter($model))->setFilter([
            $key => $value
        ])->applyFilter($query);
    }
}
