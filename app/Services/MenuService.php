<?php

namespace App\Services;

use App\Models\Menu;
use App\Repository\MenuRepository;
use App\Services\Base\BaseService;
use App\Traits\FileS3;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MenuService extends BaseService
{
    use FileS3;
    public function __construct(
        protected MenuRepository $menuRepository
    ){}

    public function index()
    {
        return $this->menuRepository->getByUser(auth()->user()->getKey());
    }

    public function store(array $data)
    {
        if(isset($data['logo'])) {
            $data['logo'] = $this->uploadS3($data['logo'], 'logo');
        }
        if(isset($data['banner'])) {
            $data['banner'] = $this->uploadS3($data['banner'], 'banner');
        }
        $data['user_id'] = auth()->id();
        return $this->menuRepository->store($data);
    }

    public function show($id)
    {
        return $this->menuRepository->getByUserAndId(auth()->id(), $id);
    }

    public function update(int $id, array $data): Menu
    {
        $old = $this->menuRepository->show($id);
        if(auth()->id() !== $old->user_id) {
            throw new ModelNotFoundException('Access denied!', ResponseAlias::HTTP_BAD_REQUEST);
        }
        if(isset($data['logo'])) {
            if($old->logo !== null) {
                $this->deleteS3($old->logo);
            }
            $data['logo'] = $this->uploadS3($data['logo'], 'logo');
        }
        if(isset($data['banner'])) {
            if($old->banner !== null) {
                $this->deleteS3($old->banner);
            }
            $data['banner'] = $this->uploadS3($data['banner'], 'banner');
        }
        $data['slug'] = Str::slug($data['name']);
        return $this->menuRepository->updateMenu($id, $data);
    }

    public function destroy(int $id): bool
    {
        $menu = $this->menuRepository->show($id);
        if(auth()->id() !== $menu->user_id) {
            throw new ModelNotFoundException('Access denied!', ResponseAlias::HTTP_BAD_REQUEST);
        }
        if($menu->logo !== null) {
            $this->deleteS3($menu->logo);
        }
        if($menu->banner !== null) {
            $this->deleteS3($menu->banner);
        }
        return $this->menuRepository->delete($id);
    }

    public function upload(Menu $menu, $type, $file)
    {
        if($type === 'logo') {
            if($menu->logo !== null) {
                $this->deleteS3($menu->logo);
            }
            $path = $this->uploadS3($file, 'logo');
            $menu->logo = $path;
        }else{
            if($menu->banner !== null) {
                $this->deleteS3($menu->banner);
            }
            $path = $this->uploadS3($file, 'banner');
            $menu->banner = $path;
        }
        $menu->save();
        return $path;
    }

    public function delete(Menu $menu, $type)
    {
        if($type === 'logo') {
            $this->deleteS3($menu->logo);
            $menu->logo = null;
        }else{
            $this->deleteS3($menu->banner);
            $menu->banner = null;
        }
        $menu->save();
        return $menu;
    }

}
