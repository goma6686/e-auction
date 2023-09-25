<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('conditions')->delete();

        DB::table('conditions')->insert([
                ['id' => '1', 'condition' => 'Unknown'],
                ['id' => '2', 'condition' => 'Like-New'],
                ['id' => '3', 'condition' => 'Used'],
                ['id' => '4', 'condition' => 'Broken'],
                ['id' => '5', 'condition' => 'For Parts/Not Working'],
                ['id' => '6', 'condition' => 'New'],
        ]);
    }
}
