<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
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
            'user_id' => $this->userid->id,
            'count_claim' => $this->countClaim($this->id),
            'comments' => $this->comments(),
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

    public function comments()
    {
        $comments = [];

        foreach ($this->reviews as $com) if (!$com->is_claim){

            $images = $this->imagesCom($com);

            $comment = [
                'text' => $com->text,
                'images' => $images,
            ];

            $comments += [ 'com_' . $com->id => $comment];
        }
        return $comments;
    }

    protected function imagesCom($com)
    {
        $images = [];
        foreach ($com->images as $img){

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
