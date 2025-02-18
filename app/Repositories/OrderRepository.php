<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data): Order
    {
        // Create and return the order
        return Order::create($data);
    }
}
