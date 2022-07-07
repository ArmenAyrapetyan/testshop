<?php

namespace App\Http\Resources;

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
            'description' => $this->description,
            'price' => $this->price,
            'type' => $this->type->name,
            'status' => $this->status->name,
            'images' => $this->images(),
        ];
    }

    public function images()
    {
        $images = [];

        foreach ($this->image as $img){

            $image = [
                'id' => $img['id'],
                'path' => $img['path'],
            ];

            $images += [
                'img_' . $img->id => $image,
            ];

        }

        return $images;
    }
}
