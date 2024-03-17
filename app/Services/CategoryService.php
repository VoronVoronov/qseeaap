<?php

namespace App\Services;

use App\Models\Category;
use App\Repository\CategoryRepository;
use App\Services\Base\BaseService;
use Illuminate\Support\Str;
use App\Traits\FileS3;

class CategoryService extends BaseService
{
    use FileS3;
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ){}

    public function index()
    {
        return $this->categoryRepository->all();
    }

    public function show(int $id): Category
    {
        return $this->categoryRepository->show($id);
    }

    public function store(array $data)
    {
        if(isset($data['img'])) {
            $data['img'] = $this->uploadS3($data['img'], 'img');
        }
        $data['slug'] = Str::slug($data['name']);
        return $this->categoryRepository->store($data);
    }

    public function update(int $id, array $data): Category
    {
        $old = $this->categoryRepository->getByMenuId(['menu_id' => $data['menu_id'], 'id' => $id]);
        if(isset($data['img'])) {
            $this->deleteS3($old->img);
            $data['img'] = $this->uploadS3($data['img'], 'img');
        }
        $data['slug'] = Str::slug($data['name']);
        return $this->categoryRepository->updateCategory($id, $data);
    }

    public function destroy(int $id): bool
    {
        $category = $this->categoryRepository->show($id);
        if($category->img !== null) {
            $this->deleteS3($category->img);
        }
        return $this->categoryRepository->delete($id);
    }

}
