<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
            'attribute_name' => $this->attribute_name,
            'unit_name' => $this->unit_name,
            'attribute_value' => $this->attribute_value,
            'name' => $this->attribute_name." ".$this->attribute_value." ".$this->unit_name,
            'has_unit' => $this->has_unit,
            'created_at' => $this->created_at?->diffForHumans(),
            'updated_at' => $this->updated_at?->diffForHumans(),
            'deleted_at' => $this->deleted_at?->diffForHumans(),
        ];
    }
}
