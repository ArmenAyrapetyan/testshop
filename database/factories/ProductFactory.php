<?php

namespace Database\Factories;

use App\Models\ProductType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name(),
            'description' => $this->faker->realText(),
            'price' => $this->faker->numberBetween(1.01, 5000.99),
            'user_id' => $this->faker->randomElement(User::select('id')->get()),
            'product_type_id' => $this->faker->randomElement(ProductType::select('id')->get()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
