<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([
                ['id' => '1', 'image' => 'sport.jpg', 'category' => 'SPORTS'],
                ['id' => '2', 'image' => 'ring.jpg', 'category' => 'JEWELRY'],
                ['id' => '3', 'image' => 'watch.jpg', 'category' => 'WATCHES'],
                ['id' => '4', 'image' => 'technology.jpg', 'category' => 'ELECTRONICS'],
                ['id' => '5', 'image' => 'hanger.jpg', 'category' => 'FASHION'],
                ['id' => '6', 'image' => 'toy.jpg', 'category' => 'TOYS'],
                ['id' => '7', 'image' => 'home.jpg', 'category' => 'HOME'],
                ['id' => '8', 'image' => 'triangle.jpg', 'category' => 'OTHER'],
        ]);
    }
}
