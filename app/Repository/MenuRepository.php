<?php

namespace App\Repository;

use App\Models\Menu;
use App\Repository\Base\BaseRepository;
use Illuminate\Support\Str;

class MenuRepository extends BaseRepository
{
//    const FREE = 3;
    public function getModel(): string
    {
        return Menu::class;
    }

    public function getByUser(int $user_id)
    {
        return Menu::where('user_id', $user_id)->get();
    }

    public function getByUserAndId($user_id, $id)
    {
        return Menu::where('user_id', $user_id)->where('id', $id)->first();
    }

    public function store(array $data)
    {
        $data['slug'] = $this->checkSlug($data['name']);
        return $this->create($data);
    }

    public function updateMenu(int $id, array $data): Menu
    {
        $data['slug'] = $this->checkSlug($data['name']);
        return $this->update($id, $data);
    }

    private function checkSlug($name): string
    {
        $slug = Str::slug($name);
        $count = Menu::where('slug', $slug)->count();
        if($count > 0) {
            $slug = $slug . '-' . time();
        }
        return $slug;
    }
}
