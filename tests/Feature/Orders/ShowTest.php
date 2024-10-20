<?php

namespace Tests\Feature\Orders;

use App\Models\Address;
use App\Models\Orders;
use App\Models\Orders\Currency;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'mysql',
    ];

    #[Test]
    public function testSuccess(): void
    {
        $address = Address::factory()->create();

        $order = Orders::factory()->create([
            'address_id' => $address->id,
        ]);

        $response = $this->get(route('api.orders.show', $order->id));
        $response->assertStatus(200);
    }

    #[Test]
    public function testNotFound(): void
    {
        $response = $this->get(route('api.orders.show', 'not-found'));
        $response->assertStatus(404);
    }
}
