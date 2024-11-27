<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Menu\StoreRequest;
use App\Http\Requests\API\v1\Menu\UpdateRequest;
use App\Http\Resources\API\v1\MenuResource;
use App\Http\Resources\API\v1\Collection\MenuResourceCollection;
use App\Services\MenuService;
use Symfony\Component\HttpFoundation\JsonResponse;

class MenuController extends Controller
{
    public function __construct(
        protected MenuService $menuService
    ){}

    public function index(): MenuResourceCollection
    {
        return MenuResourceCollection::make($this->menuService->index());
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $menu = $this->menuService->store($request->all());

        return response()->json([
            'id' => $menu->getKey(),
        ]);
    }

    public function show(int $id): MenuResource
    {
        return MenuResource::make($this->menuService->show($id));
    }

    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $menu = $this->menuService->update($id, $request->all());

        return response()->json([
            'message' => __('menu.updated'),
            'menu' => $menu,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->menuService->destroy($id);

        return response()->json([
            'message' => __('menu.deleted'),
            'success' => true
        ]);
    }
}
