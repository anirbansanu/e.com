<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\MediaResource;
use App\Http\Resources\Product\ProductReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => new ProductCategoryResource($this->whenLoaded('category')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            // 'variations' => $this->whenLoaded('productToVariations',$this->groupByVariation(),null),
            'variations' => $this->whenLoaded('productToVariations', function () {
                return ProductToVariationResource::collection($this->productToVariations)
                    ->groupBy('variant_name');
            }),
            'stock' => StockResource::collection($this->whenLoaded('stocks')),
            'added_by' => $this->addedBy,
            'price' => $this->price,
            'gender' => $this->gender,
            'feature' => $this->feature,
            'is_active' => $this->is_active,
            'rating' => $this->whenLoaded('reviews', $this->rating, 0),
            'reviews' => ProductReviewResource::collection($this->whenLoaded('reviews')),
            'step' => $this->step,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
