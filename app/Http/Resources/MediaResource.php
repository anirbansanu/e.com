<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class MediaResource extends JsonResource
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
            'url' => $this->url,
            'thumb'  => $this->thumb,
            'icon' => $this->icon,
            'formated_size'=> $this->formated_size,
            'size'=> $this->size,
            'uuid'=> $this->uuid,
            'type'=> $this->mime_type,
            "name" => $this->file_name,
            "collection_name" => $this->collection_name,
        ];
    }
}
