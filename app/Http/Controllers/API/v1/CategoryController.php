<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Category\StoreRequest;
use App\Http\Requests\API\v1\Category\UpdateRequest;
use App\Http\Resources\API\v1\CategoryResource;
use App\Repository\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct
    (
        protected CategoryService $categoryService,
        protected CategoryRepository $categoryRepository
    ){}

    public function index(Request $request): CategoryResource
    {
        $per_page = $request->get('per_page') ?? 50;
        return CategoryResource::make($this->categoryRepository->setFilter($request->get('filter'))->paginated($per_page))->additional($this->categoryRepository->getRangeInfo());
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $category = $this->categoryService->store($request->all());

        return response()->json([
            'id' => $category->getKey(),
        ]);
    }

    public function show($id): CategoryResource
    {
        return CategoryResource::make($this->categoryService->show($id));
    }

    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $category = $this->categoryService->update($id, $request->all());

        return response()->json([
            'message' => __('category.updated'),
            'category' => $category,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->categoryService->destroy($id);

        return response()->json([
            'message' => __('category.deleted'),
        ]);
    }
}
