<?php

namespace App\Http\Resources\API\v1\Collection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Collection;

class MenuResourceCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return Collection::make($this->resource)->map(function ($menu) {
            return [
                'id' => $menu->getKey(),
                'tariff_id' => $menu->tariff_id,
                'user_id' => $menu->user_id,
                'name' => $menu->name,
                'slug' => $menu->slug,
                'description' => $menu->description,
                'address' => $menu->address,
                'mode' => $menu->mode,
                'work_time' => $menu->work_time,
                'logo' => $menu->logo,
                'banner' => $menu->banner,
            ];
        })->toArray();
    }
}
