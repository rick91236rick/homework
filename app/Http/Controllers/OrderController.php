<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Http\Requests\Order\StoreRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService
    )
    {
    }

    public function store(StoreRequest $request)
    {
        $order = $this->orderService->createOrder($request->getOrderInfo());
        event(new OrderCreated($order));

        return response()->json(['order' => $order->toArray()]);
    }

    public function show(string $id)
    {
        $order = $this->orderService->getOrderById($id);

        if (is_null($order)) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['order' => $order->toArray()]);
    }
}
