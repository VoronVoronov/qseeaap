<?php

namespace App\Http\Resources\API\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'modules' => $this->modules->map(function ($module) {
                return [
                    'id' => $module->id,
                    'name' => $module->name,
                    'code' => $module->code,
                ];
            }),
        ]);
    }
}
