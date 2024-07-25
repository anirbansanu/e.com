<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\StockResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->whenLoaded('user'),
            'product' => $this->whenLoaded('product'),
            'quantity' => $this->quantity,
            'stock' => new StockResource($this->whenLoaded('stock')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
