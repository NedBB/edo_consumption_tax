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
        $businessTypes = [
            ['name' => 'Bars'],
            ['name' => 'Hotels'],
            ['name' => 'Guest Houses'],
            ['name' => 'Motels'],
            ['name' => 'Event Centres'],
            ['name' => 'Restaurants'],
            ['name' => 'Online Drinks Trading']
        ];

        // Insert data
        DB::table('categories')->insert($businessTypes);
    }
}
