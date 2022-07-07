<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResourse extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role->name,
            'ban_count' => $this->ban_count,
        ];
    }

    public function products()
    {
        $products = [];

        foreach ($this->products as $product){

            $prd = new ProductResource($product);

            $products += [
                'product_' . $product->id => $prd,
            ];
        }

        return $products;
    }
}
