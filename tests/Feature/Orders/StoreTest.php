<?php

namespace Tests\Feature\Orders;

use App\Models\Orders\Currency;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'mysql',
    ];

    #[Test]
    public function testTWDSuccess(): void
    {
        $body = $this->getFakeBody(Currency::TWD);
        $response = $this->post(route('api.orders.store'), $body);
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
            'currency' => $body['currency'],
        ]);

        $this->assertDatabaseHas('orders_twd', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
        ]);
    }

    #[Test]
    public function testUSDSuccess(): void
    {
        $body = $this->getFakeBody(Currency::USD);
        $response = $this->post(route('api.orders.store'), $body);
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
            'currency' => $body['currency'],
        ]);

        $this->assertDatabaseHas('orders_usd', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
        ]);
    }

    #[Test]
    public function testJPYSuccess(): void
    {
        $body = $this->getFakeBody(Currency::JPY);
        $response = $this->post(route('api.orders.store'), $body);
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
            'currency' => $body['currency'],
        ]);

        $this->assertDatabaseHas('orders_jpy', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
        ]);
    }

    #[Test]
    public function testRMBSuccess(): void
    {
        $body = $this->getFakeBody(Currency::RMB);
        $response = $this->post(route('api.orders.store'), $body);
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
            'currency' => $body['currency'],
        ]);

        $this->assertDatabaseHas('orders_rmb', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
        ]);
    }

    #[Test]
    public function testMYRSuccess(): void
    {
        $body = $this->getFakeBody(Currency::MYR);
        $response = $this->post(route('api.orders.store'), $body);
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
            'currency' => $body['currency'],
        ]);

        $this->assertDatabaseHas('orders_myr', [
            'id' => $body['id'],
            'name' => $body['name'],
            'price' => $body['price'],
        ]);
    }

    #[Test]
    public function testCurrencyFail(): void
    {
        $body = $this->getFakeBody();
        $response = $this->post(route('api.orders.store'), $body);
        $response->assertStatus(422);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('orders_twd', 0);
        $this->assertDatabaseCount('orders_usd', 0);
        $this->assertDatabaseCount('orders_jpy', 0);
        $this->assertDatabaseCount('orders_rmb', 0);
        $this->assertDatabaseCount('orders_myr', 0);
    }

    private function getFakeBody(Currency $currency = null): array
    {
        return [
            'id' => 'A' . fake()->randomNumber(6),
            'name' => fake()->name(),
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road',
            ],
            'price' => '2050',
            'currency' => is_null($currency) ? 'XXX' : $currency->value,
        ];
    }
}
