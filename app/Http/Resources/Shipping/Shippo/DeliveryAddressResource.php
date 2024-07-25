<?php

namespace App\Http\Resources\Shipping\Shippo;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryAddressResource extends JsonResource
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
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'city_locality' => $this->city_locality,
            'state_province' => $this->state_province,
            'postal_code' => $this->postal_code,
            'country_code' => $this->country_code,
            'organization' => $this->organization,
            'phone' => $this->phone,
            'email' => $this->email,
            'is_default' => $this->is_default, // Include is_default field
            'user' => $this->whenLoaded('user'),
            'full_address' => $this->fullAddress(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
