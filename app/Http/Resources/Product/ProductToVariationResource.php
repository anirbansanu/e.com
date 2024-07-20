<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductToVariationResource extends JsonResource
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
            'variation_id' => $this->variation_id,
            'unit_id' => $this->unit_id,
            'variant_value' => $this->variant_value,
            'variant_name' => $this->whenLoaded('variation',$this->variation->name,null),
            'unit_name' => $this->whenLoaded('unit',$this->unit?$this->unit->unit_name:null),
            'has_unit' => $this->has_unit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'variation' => new VariationResource($this->whenLoaded('variation')),
            'unit' => new ProductUnitResource($this->whenLoaded('unit')),
        ];
    }
}
