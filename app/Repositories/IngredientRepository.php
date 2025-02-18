<?php
namespace App\Repositories;

use App\Models\Ingredient;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockAlert;

class IngredientRepository implements IngredientRepositoryInterface
{
    /**
     * @param Ingredient $ingredient
     * @param float $amount
     * @return bool
     */
    public function updateStock(Ingredient $ingredient, float $amount): bool
    {
        $ingredient->stock -= $amount;
        return $ingredient->save();
    }

    /**
     * @param $ingredient
     * @param $amount
     * @return void
     */
    public function deductStock($ingredient, $amount): void
    {
        $ingredient->decrement('stock', $amount);

        $stockLimit = $ingredient->initial_stock * 0.5;

        if ($ingredient->stock <= $stockLimit && !$ingredient->alert_sent) {
            // Send alert and update flag
            Mail::to(env('MERCHANT_EMAIL'))->send(new LowStockAlert($ingredient));
            $ingredient->update(['alert_sent' => true]);
        }
    }
}
