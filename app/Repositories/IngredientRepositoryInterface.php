<?php

namespace App\Repositories;

use App\Models\Ingredient;

interface IngredientRepositoryInterface
{
    public function updateStock(Ingredient $ingredient, float $amount): bool;
    public function deductStock($ingredient, $amount): void;
}
