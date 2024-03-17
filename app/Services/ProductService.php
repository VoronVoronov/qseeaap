<?php

namespace App\Services;

use App\Models\Product;
use App\Repository\ProductRepository;
use App\Services\Base\BaseService;
use App\Traits\FileS3;
use Illuminate\Support\Str;

class ProductService extends BaseService
{
    use FileS3;
    public function __construct(
        protected ProductRepository $productRepository,
    ){}

    public function index()
    {
        return $this->productRepository->all();
    }

    public function show(int $id): Product
    {
        return $this->productRepository->show($id);
    }

    public function store(array $data)
    {
        if(isset($data['img'])) {
            $data['img'] = $this->uploadS3($data['img'], 'img');
        }
        return $this->productRepository->create($data);
    }

    public function update(int $id, array $data): Product
    {
        $old = $this->productRepository->getByCategoryId(['category_id' => $data['category_id'], 'id' => $id]);
        if(isset($data['img'])) {
            $this->deleteS3($old->img);
            $data['img'] = $this->uploadS3($data['img'], 'img');
        }
        return $this->productRepository->update($id, $data);
    }

    public function destroy(int $id): bool
    {
        $Product = $this->productRepository->show($id);
        if($Product->img !== null) {
            $this->deleteS3($Product->img);
        }
        return $this->productRepository->delete($id);
    }
}
