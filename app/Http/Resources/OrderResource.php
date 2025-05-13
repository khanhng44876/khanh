<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetailResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'total'=>$this->total,
            'created'=>$this->created_at->toDateTimeString(),
            'detail'=>OrderDetailResource::collection($this->whenLoaded('detail'))
        ];
    }
}
