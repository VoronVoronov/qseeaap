<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Product\StoreRequest;
use App\Http\Requests\API\v1\Product\UpdateRequest;
use App\Http\Resources\API\v1\ProductResource;
use App\Repository\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct
    (
        protected ProductService $productService,
        protected ProductRepository $productRepository
    ){}

    public function index(Request $request)
    {
        $per_page = $request->get('per_page') ?? 50;
        return ProductResource::make($this->productRepository->setFilter($request->get('filter'))->paginated($per_page))->additional($this->productRepository->getRangeInfo());
    }

    public function store(StoreRequest $request)
    {
        $category = $this->productService->store($request->all());

        return response()->json([
            'id' => $category->getKey(),
        ]);
    }

    public function show($id)
    {
        return ProductResource::make($this->productService->show($id));
    }

    public function update(UpdateRequest $request, $id)
    {
        $category = $this->productService->update($id, $request->all());

        return response()->json([
            'message' => __('product.updated'),
            'category' => $category,
        ]);
    }

    public function destroy($id)
    {
        $this->productService->destroy($id);

        return response()->json([
            'message' => __('product.deleted'),
        ]);
    }
}
