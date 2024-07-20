<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Customer\Stock\StockResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
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
            'payable_amount'    => $this->price,
            'quantity'          => $this->quantity,
            'payment_mode'      => (string) $this->order->payment_mode ?? '',
            'shipping_status'   => $this->order->shipping_status ?? '',
            'payment_status'    => $this->order->payment_status ?? '',
            'stock'             => ($this->stock) ? new StockResource( $this->stock ) : [],
            'place_order_at'    => $this->created_at
        ];
    }
}
