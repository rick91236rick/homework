<?php

namespace App\Services;

use App\Http\Domains\Order\ValueObjects\OrderInfo;
use App\Models\Orders;
use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepositories
    ) {
    }

    public function createOrder(OrderInfo $info): Orders
    {
        return $this->orderRepositories->createOrder($info);
    }

    public function getOrderById(string $orderId): ?Orders
    {
        return $this->orderRepositories->getById($orderId);
    }
}