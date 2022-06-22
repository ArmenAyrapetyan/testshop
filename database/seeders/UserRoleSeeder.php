<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [];

        $nameRole = ['Администратор', 'Пользователь'];

        for ($i = 0; $i < 2; $i++){
            $roles[] = [
                'name' => $nameRole[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('user_roles')->insert($roles);
    }
}
