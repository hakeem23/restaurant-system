<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\IngredientRepositoryInterface;
use App\Http\Requests\PlaceOrderRequest;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected OrderRepositoryInterface $orderRepository;
    protected IngredientRepositoryInterface $ingredientRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, IngredientRepositoryInterface $ingredientRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->ingredientRepository = $ingredientRepository;
    }

    /**
     * placeOrder
     *
     * @param PlaceOrderRequest $request
     * @return mixed
     */
    public function placeOrder(PlaceOrderRequest $request): mixed
    {
        DB::beginTransaction();
        try {
            // Create the order using the repository
            $order = $this->orderRepository->create($request->validated());

            // Fetch all product IDs in one query
            $productIds = collect($request->products)->pluck('product_id');
            $products = Product::with('ingredients')->whereIn('id', $productIds)->get();

            foreach ($request->products as $orderItem) {
                $product = $products->find($orderItem['product_id']);
                if (!$product) {
                    throw new \Exception("Product ID {$orderItem['product_id']} not found.");
                }

                $quantity = $orderItem['quantity'];

                // Attach product to order
                $order->products()->attach($product->id, ['quantity' => $quantity]);

                // Check stock and update ingredients
                foreach ($product->ingredients as $ingredient) {
                    $requiredAmount = $ingredient->pivot->amount * $quantity;

                    if ($ingredient->stock < $requiredAmount) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'error',
                            'message' => "Not enough stock for {$ingredient->name}. Required: $requiredAmount, Available: {$ingredient->stock}"
                        ], 400);
                    }

                    // Update stock & check low stock alerts via repository
                    $this->ingredientRepository->deductStock($ingredient, $requiredAmount);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Order placed successfully!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while placing the order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

