<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [];

        $nameStatus = ['Продан', 'Скрыт', 'Продается'];

        for ($i = 0; $i < 2; $i++){
            $roles[] = [
                'name' => $nameStatus[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('statuses')->insert($roles);
    }
}
