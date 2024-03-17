<?php

namespace App\Repository;

use App\Models\Category;
use App\Repository\Base\BaseRepository;
use App\Traits\Repository\HasRangeInfo;
use Illuminate\Support\Str;

class CategoryRepository extends BaseRepository
{
    use HasRangeInfo;

    public function getModel(): string
    {
        return Category::class;
    }

    public function getByMenuId(array $data)
    {
        return Category::where('menu_id', $data['menu_id'])
            ->where('id', $data['id'])
            ->first();
    }

    public function store(array $data)
    {
        $data['slug'] = $this->checkSlug($data['name'], $data['menu_id']);
        return $this->create($data);
    }

    public function updateCategory(int $id, array $data): Category
    {
        $data['slug'] = $this->checkSlug($data['name'], $data['menu_id']);
        return $this->update($id, $data);
    }

    private function checkSlug($name, $menu_id): string
    {
        $slug = Str::slug($name);
        $count = Category::where('slug', $slug)->where('menu_id', $menu_id)->count();
        if($count > 0) {
            $slug = $slug . '-' . time();
        }
        return $slug;
    }
}
