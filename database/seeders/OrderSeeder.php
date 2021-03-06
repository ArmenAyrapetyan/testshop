<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ProductsOrder;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory(25)->create();
        ProductsOrder::factory(80)->create();
    }
}
