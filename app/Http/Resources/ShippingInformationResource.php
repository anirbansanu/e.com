<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ShippingInformationResource extends JsonResource
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
            'stock_id' => $this->stock_id,
            'distance_unit' => $this->distance_unit,
            'height' => $this->height,
            'length' => $this->length,
            'mass_unit' => $this->mass_unit,
            'weight' => $this->weight,
            'width' => $this->width,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

