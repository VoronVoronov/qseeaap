<?php

namespace App\Repository;

use App\Models\Product;
use App\Repository\Base\BaseRepository;
use App\Traits\Repository\HasRangeInfo;

class ProductRepository extends BaseRepository
{
    use HasRangeInfo;

    public function getModel(): string
    {
        return Product::class;
    }

    public function getByCategoryId(array $data)
    {
        return Product::where('category_id', $data['category_id'])->where('id', $data['id'])->first();
    }
}
