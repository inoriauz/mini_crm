<?php

namespace App\Repositories;

use App\Models\Order;
use App\Interfaces\OrderInterface;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository implements OrderInterface
{

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function find(int $id): ?Order
    {
        return Order::find($id);
    }

    public function query(): Builder
    {
        return Order::query();
    }
}
