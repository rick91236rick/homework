<?php

namespace Database\Factories;

use App\Models\Orders\Currency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string) ('A' . fake()->numberBetween(1, 99999999)),
            'address_id' => fake()->numberBetween(1, 99999999),
            'name' => fake()->name,
            'price' => fake()->numberBetween(1, 99999999),
            'currency' => Currency::TWD,
            'created_at' => Carbon::parse(fake()->dateTimeThisMonth),
            'updated_at' => Carbon::parse(fake()->dateTimeThisMonth),
        ];
    }
}
