<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'quantity'=>$this->quantity,
            'product'=>[
                'id'=>$this->product->id,
                'name'=>$this->product->name,
                'price'=>$this->product->price,
                'img'=>$this->product->img
            ],
        ];
    }
}
