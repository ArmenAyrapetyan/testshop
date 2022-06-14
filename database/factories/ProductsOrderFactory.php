<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductsOrder>
 */
class ProductsOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_id' => $this->faker->randomElement(Order::select('id')->get()),
            'product_id' => $this->faker->randomElement(Product::select('id')->get()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
