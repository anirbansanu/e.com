<?php

namespace App\Http\Resources\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'company_name'      => (string) $this->company_name ?? '',
            'company_email'     => (string) $this->company_email ?? '',
            'company_phone_no'  => (string) $this->company_phone_no ?? '',
            'registration_id'   => (string) $this->registration_id ?? '',
            'license_no'        => (string) $this->license_no ?? ''
        ];
    }
}
