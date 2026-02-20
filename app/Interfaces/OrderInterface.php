<?php

namespace App\Interfaces;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

interface OrderInterface
{
    public function create(array $data): Order;

    public function find(int $id): ?Order;

    public function query(): Builder;
}
