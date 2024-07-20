<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Customer\Stock\StockResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'                => $this->id,
            'price'             => $this->price ?? '',
            'quantity'          => $this->quantity ?? '',
            'shipping_status'   => $this->order->shipping_status ?? '',
            'payment_status'    => $this->order->payment_status ?? '',
            'stock'             => ($this->stock) ? new StockResource( $this->stock ) : [],
            'place_order_at'    => $this->created_at
        ];
    }
}
