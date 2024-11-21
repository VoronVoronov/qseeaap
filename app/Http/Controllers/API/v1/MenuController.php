<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Menu\StoreRequest;
use App\Http\Requests\API\v1\Menu\UpdateRequest;
use App\Http\Resources\API\v1\MenuResource;
use App\Services\MenuService;

class MenuController extends Controller
{
    public function __construct(
        protected MenuService $menuService
    ){}

    public function index()
    {
        return MenuResource::make($this->menuService->index());
    }

    public function store(StoreRequest $request)
    {
        $menu = $this->menuService->store($request->all());

        return response()->json([
            'id' => $menu->getKey(),
        ]);
    }

    public function show(string $id)
    {
        return MenuResource::make($this->menuService->show($id));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $menu = $this->menuService->update($id, $request->all());

        return response()->json([
            'message' => __('menu.updated'),
            'menu' => $menu,
        ]);
    }

    public function destroy(string $id)
    {
        $this->menuService->destroy($id);

        return response()->json([
            'message' => __('menu.deleted'),
            'success' => true
        ]);
    }
}
