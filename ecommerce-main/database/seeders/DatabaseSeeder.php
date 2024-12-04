<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Meifer Rodriguez',
            'email' => 'juanjo_meifer@hotmail.com',
        ]);

        User::factory()->create([
            'name' => 'Jose Rios',
            'email' => 'joseluisrios999@gmail.com',
        ]);


        User::factory(10)->create();

        Category::factory(5)->create();

        Product::factory(20)->create();
    }
}
