<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imageable = [];

        for ($i = 1; $i < Product::all()->count()+1; $i++) {
            $imageable[] = [
              'path' => 'storage/images/img.png',
              'imageable_id' => $i,
              'imageable_type' => Product::class,
            ];
        }

        for ($i = 1; $i < User::all()->count()+1; $i++) {
            $imageable[] = [
              'path' => 'storage/images/imguser.png',
              'imageable_id' => $i,
              'imageable_type' => User::class,
            ];
        }

        DB::table('images')->insert($imageable);
    }
}
