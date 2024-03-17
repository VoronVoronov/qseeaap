<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Tariff\StoreRequest;
use App\Http\Requests\API\v1\Tariff\UpdateRequest;
use Illuminate\Http\Request;
use App\Services\TariffService;
use App\Http\Resources\API\v1\TariffResource;

class TariffController extends Controller
{
    public function __construct(
        protected TariffService $tariffService
    ){}
    public function index()
    {
        return TariffResource::collection($this->tariffService->index());
    }


    public function store(StoreRequest $request)
    {
        $tariff = $this->tariffService->store($request->all());

        return response()->json([
            'id' => $tariff->getKey(),
        ]);
    }

    public function show(int $id)
    {
        return TariffResource::make($this->tariffService->show($id));
    }

    public function update(UpdateRequest $request, int $id)
    {
        $tariff = $this->tariffService->update($id, $request->all());

        return response()->json([
            'message' => __('tariff.updated'),
            'tariff' => $tariff,
        ]);
    }

    public function destroy(int $id)
    {
        $this->tariffService->destroy($id);

        return response()->json([
            'message' => __('tariff.deleted'),
        ]);
    }
}
