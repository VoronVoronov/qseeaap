<?php

namespace App\Http\Resources\API\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return array_merge(parent::toArray($request), [
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'work_time' => $this->work_time,
        ]);
    }
}
