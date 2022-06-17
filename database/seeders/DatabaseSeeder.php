<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductsOrder;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)->create();
        ProductType::factory(40)->create();
        Product::factory(120)->create();
        Order::factory(25)->create();
        ProductsOrder::factory(80)->create();
    }
}
