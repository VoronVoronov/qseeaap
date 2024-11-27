<?php

namespace App\Http\Resources\API\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\TariffModule;

class TariffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price_one_month,
            'features' => TariffModule::all()->map(function ($module) {
                return [
                    'name' => $module->name,
                    'included' => $module->access->where('tariff_id', $this->id)->count(),
                ];
            }),
        ];
    }
}
