<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\MediaResource;
use App\Http\Resources\ShippingInformationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product_price_id' => $this->product_price_id,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'is_default'=> $this->is_default,
            'has_media' => $this->has_media,
            'media' => MediaResource::collection($this->getMedia('image')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'product_price' => $this->whenLoaded('productPrice',$this->productPrice->price),
            'variations' => $this->whenLoaded('combinations', function () {
                return $this->combinations->groupBy('variant_name');
            }),
            'combinations' => $this->whenLoaded('combinations',$this->combinations),
            'shipping_information' => new ShippingInformationResource($this->whenLoaded('shippingInformation')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
