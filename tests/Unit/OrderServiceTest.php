<?php

namespace Tests\Unit;

use App\Http\Domains\Order\ValueObjects\Address;
use App\Http\Domains\Order\ValueObjects\OrderInfo;
use App\Models\Orders;
use App\Models\Orders\Currency;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{

    private OrderService $target;

    private MockInterface&OrderRepository $orderRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = $this->partialMock(OrderRepository::class);
        $this->target = $this->app->make(OrderService::class);
    }

    #[Test]
    public function testCreateOrderSucess(): void
    {
        $orderInfo = new OrderInfo(
            id: '1',
            name: 'test',
            address: new Address(
                city: 'Taipei',
                district: 'Daan',
                street: 'test',
            ),
            price: 100,
            currency: Currency::TWD,
        );

        $order = Orders::factory()->make([
            'id' => $orderInfo->id,
            'name' => $orderInfo->name,
            'price' => $orderInfo->price,
            'currency' => $orderInfo->currency,
            'address' => 123,
        ]);

        $this->orderRepository->shouldReceive('createOrder')
            ->andReturn($order);
        $result = $this->target->createOrder($orderInfo);
        $this->assertSame($orderInfo->name, $result->name);
        $this->assertSame($orderInfo->price, $result->price);
        $this->assertSame($orderInfo->currency, $result->currency);
    }

    #[Test]
    public function testGetOrderByIdSuccess(): void
    {
        $orderId = '1';
        $order = Orders::factory()->make([
            'id' => $orderId,
            'name' => 'test',
            'price' => 100,
            'currency' => Currency::TWD,
            'address' => 123,
        ]);

        $this->orderRepository->shouldReceive('getById')
            ->andReturn($order);
        $result = $this->target->getOrderById($orderId);

        $this->assertSame($orderId, $result->id);
        $this->assertSame($order->name, $result->name);
        $this->assertSame($order->price, $result->price);
        $this->assertSame($order->currency, $result->currency);
    }

    #[Test]
    public function testGetOrderByIdNotFound(): void
    {
        $orderId = '1';
        $this->orderRepository->shouldReceive('getById')
            ->with($orderId)
            ->andReturn(null);
        $result = $this->target->getOrderById($orderId);
        $this->assertNull($result);
    }
}
