<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function __construct(protected OrderRepository $orderRepository)
    {

    }

    public function create(array $data): Order
    {
        $data['status'] = $data['status'] ?? 'new';

        return $this->orderRepository->create($data);
    }

    public function changeStatus(Order $order, string $status, $user): Order
    {

        if ($user->role === 'manager' && $order->manager_id !== $user->id) {
            abort(403);
        }

        $order->update(['status' => $status]);

        return $order;

    }

    public function getOrdersForUser($user, ?string $status = null): Collection
    {

        $query = $this->orderRepository->query();

        if ($user->role === 'manager') {

            $query->where('manager_id', $user->id);

        }

        if ($status) {

            $query->where('status', $status);

        }

        return $query->latest()
            ->get();

    }
}
