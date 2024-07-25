<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'added_by' => $this->addedBy,
            'category' => new ProductCategoryResource($this->whenLoaded('category')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'stock' => new StockDefaultResource($this->whenLoaded('defaultStock',$this->defaultStock,null)),
            'is_active' => $this->is_active,
            'step'=> $this->step,
            'rating' => $this->whenLoaded('reviews', $this->rating, 0),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }


}
