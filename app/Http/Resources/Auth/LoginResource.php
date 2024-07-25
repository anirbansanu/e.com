<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
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
            'id'                => (int) $this->id,
            'name'              => (string) $this->name ?? '',
            'gender'            => (string) $this->gender ?? '',
            'profile_photo'     => (string) $this->profile_photo ?? '',
            'email'             => (string) $this->email ?? '',
            'phone'             => (string) $this->phone ?? '',
            'birthday'          => (string) $this->birthday ?? '',
            'post'              => (string) $this->post ?? '',
            'follwers'          => (integer) $this->follwers ?? '',
            'followings'        => (integer) $this->followings ?? '',
            'timelinedata'      => $this->timelinedata ?? '',
            'latitude'          => (float) $this->latitude ?? '',
            'longitude'         => (float) $this->longitude ?? '',
            'is_active'         => (integer) $this->is_active ?? '',
            'device_token'      => (string) $this->device_token ?? '',
            'is_online'         => (integer) $this->is_online ?? '',
            'terms_conditions'  => (integer) $this->terms_conditions ?? '',
            'roles'             => RoleResource::collection($this->roles) ?? [],
        ];
    }
}
