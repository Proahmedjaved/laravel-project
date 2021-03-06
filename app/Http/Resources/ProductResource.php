<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'image' => $this->image == 'avatar.jpg' ? asset('image/avatar.jpg') : $this->image,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
