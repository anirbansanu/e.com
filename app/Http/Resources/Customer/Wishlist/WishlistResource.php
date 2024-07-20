<?php

namespace App\Http\Resources\Customer\Wishlist;

use App\Http\Resources\Customer\Stock\StockResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'                => $this->id,
            'stock'             => ($this->stock) ? new StockResource( $this->stock ) : []
        ];
    }
}
