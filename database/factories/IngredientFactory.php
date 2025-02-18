<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'stock' => $this->faker->randomFloat(2, 10, 100), // Stock between 10 and 100
            'initial_stock' => 100, // Default initial stock
            'alert_sent' => false, // Default value for alerts
        ];
    }
}
