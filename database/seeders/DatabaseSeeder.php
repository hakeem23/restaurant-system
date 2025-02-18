<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $beef = Ingredient::create(['name' => 'Beef', 'stock' => 20000, 'initial_stock' => 20000]);
        $cheese = Ingredient::create(['name' => 'Cheese', 'stock' => 5000, 'initial_stock' => 5000]);
        $onion = Ingredient::create(['name' => 'Onion', 'stock' => 1000, 'initial_stock' => 1000]);

        $burger = Product::create(['name' => 'Burger']);

        $burger->ingredients()->attach([
            $beef->id => ['amount' => 150],
            $cheese->id => ['amount' => 30],
            $onion->id => ['amount' => 20],
        ]);
    }
}
