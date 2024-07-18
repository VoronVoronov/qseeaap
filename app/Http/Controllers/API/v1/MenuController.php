<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Menu\StoreRequest;
use App\Http\Requests\API\v1\Menu\UpdateRequest;
use App\Http\Resources\API\v1\MenuResource;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function show($id)
    {
        return MenuResource::make($this->menuService->show($id));
    }

    public function update(UpdateRequest $request, $id)
    {
        $menu = $this->menuService->update($id, $request->all());

        return response()->json([
            'message' => __('menu.updated'),
            'menu' => $menu,
        ]);
    }

    public function destroy($id)
    {
        $this->menuService->destroy($id);

        return response()->json([
            'message' => __('menu.deleted'),
        ]);
    }

    public function upload(Request $request)
    {
        if($request->type == 'logo') {
            $validator = Validator::make($request->all(), [
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:32000',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:32000',
            ]);
        }
        if ($validator->fails()) {
            return response()->json([
                'message' => __('menu.file_size', ['size' => 32]),
            ], 400);
        }
        $menu = $this->menuService->show($request->menu_id);
        if (!$menu) {
            return response()->json([
                'message' => __('menu.not_found'),
            ], 404);
        }
        if($request->type == 'logo') {
            $this->menuService->upload($menu, 'logo', $request->file('logo'));
        }else{
            $this->menuService->upload($menu, 'banner', $request->file('banner'));
        }

        return response()->json([
            'message' => __('menu.uploaded'),
        ]);
    }

    public function delete(Request $request)
    {
        $menu = $this->menuService->show($request->menu_id);
        if (!$menu) {
            return response()->json([
                'message' => __('menu.not_found'),
            ], 404);
        }
        if($request->type == 'logo') {
            $this->menuService->delete($menu, 'logo');
        }else{
            $this->menuService->delete($menu, 'banner');
        }

        return response()->json([
            'message' => __('menu.deleted'),
        ]);
    }
}
