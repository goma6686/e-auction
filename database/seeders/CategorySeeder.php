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
                ['id' => '1', 'categoryImage' => 'sport.jpg', 'category' => 'SPORTS'],
                ['id' => '2', 'categoryImage' => 'ring.jpg', 'category' => 'JEWELRY'],
                ['id' => '3', 'categoryImage' => 'watch.jpg', 'category' => 'WATCHES'],
                ['id' => '4', 'categoryImage' => 'technology.jpg', 'category' => 'ELECTRONICS'],
                ['id' => '5', 'categoryImage' => 'hanger.jpg', 'category' => 'FASHION'],
                ['id' => '6', 'categoryImage' => 'toy.jpg', 'category' => 'TOYS'],
                ['id' => '7', 'categoryImage' => 'home.jpg', 'category' => 'HOME'],
                ['id' => '8', 'categoryImage' => 'triangle.jpg', 'category' => 'OTHER'],
        ]);
    }
}
