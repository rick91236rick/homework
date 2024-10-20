<?php

namespace Database\Factories;

use App\Models\Orders\Currency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddRessFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => fake()->numberBetween(1, 99999999),
            'city' => fake()->name,
            'district' => fake()->name,
            'street' => fake()->name,
            'created_at' => Carbon::parse(fake()->dateTimeThisMonth),
            'updated_at' => Carbon::parse(fake()->dateTimeThisMonth),
        ];
    }
}
