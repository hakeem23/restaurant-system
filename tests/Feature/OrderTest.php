<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Run all seeders before each test
        $this->seed();
    }
    public function test_order_is_stored_and_stock_is_updated()
    {
        $this->seed(); // Seed database

        $burger = Product::first();

        $response = $this->postJson('/api/orders', [
            'products' => [
                ['product_id' => $burger->id, 'quantity' => 2]
            ]
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', []);
        $this->assertDatabaseHas('ingredients', ['name' => 'Beef', 'stock' => 19700]);
        $this->assertDatabaseHas('ingredients', ['name' => 'Cheese', 'stock' => 4940]);
    }
}
