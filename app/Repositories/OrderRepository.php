<?php

namespace App\Repositories;

use App\Http\Domains\Order\ValueObjects\OrderInfo;
use App\Models\Orders;
use App\Models\Address;
use App\Models\OrdersJpy;
use App\Models\OrdersMyr;
use App\Models\OrdersRmb;
use App\Models\OrdersTwd;
use App\Models\OrdersUsd;

class OrderRepository
{
    public function getById(string $id): ?Orders
    {
        return Orders::find($id);
    }

    public function createOrder(OrderInfo $orderData): Orders
    {
        $address = new Address([
            'city' => $orderData->address->city,
            'district' => $orderData->address->district,
            'street' => $orderData->address->street,
        ]);

        $address->save();

        $order = new Orders([
            'id' => $orderData->id,
            'name' => $orderData->name,
            'address_id' => $address->id,
            'price' => $orderData->price,
            'currency' => $orderData->currency,
        ]);

        $order->save();
        $order->refresh();
        return $order;
    }

    public function createTWDOrder(Orders $order): OrdersTwd
    {
        $twdOrder = new OrdersTwd(
            [
                'id' => $order->id,
                'name' => $order->name,
                'address_id' => $order->address_id,
                'price' => $order->price,
            ]
        );

        $twdOrder->save();
        return $twdOrder;
    }

    public function createUSDOrder(Orders $order): OrdersUsd
    {
        $twdOrder = new OrdersUsd(
            [
                'id' => $order->id,
                'name' => $order->name,
                'address_id' => $order->address_id,
                'price' => $order->price,
            ]
        );
        $twdOrder->save();
        return $twdOrder;
    }

    public function createJPYOrder(Orders $order): OrdersJpy
    {
        $twdOrder = new OrdersJpy(
            [
                'id' => $order->id,
                'name' => $order->name,
                'address_id' => $order->address_id,
                'price' => $order->price,
            ]
        );
        $twdOrder->save();
        return $twdOrder;
    }

    public function createRMBOrder(Orders $order): OrdersRmb
    {
        $twdOrder = new OrdersRmb(
            [
                'id' => $order->id,
                'name' => $order->name,
                'address_id' => $order->address_id,
                'price' => $order->price,
            ]
        );
        $twdOrder->save();
        return $twdOrder;
    }

    public function createMYROrder(Orders $order): OrdersMyr
    {
        $twdOrder = new OrdersMyr(
            [
                'id' => $order->id,
                'name' => $order->name,
                'address_id' => $order->address_id,
                'price' => $order->price,
            ]
        );
        $twdOrder->save();
        return $twdOrder;
    }
}
