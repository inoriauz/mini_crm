<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct(protected OrderService $orderService)
    {

    }

    public function index(Request $request)
    {

        $orders = $this->orderService->getOrdersForUser(
            $request->user(),
            $request->status
        );

        return $this->successResponse($orders, 'Orders retrieved successfully');

    }

}
