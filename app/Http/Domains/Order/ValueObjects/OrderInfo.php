<?php

namespace App\Http\Domains\Order\ValueObjects;

use App\Models\Orders\Currency;

final readonly class OrderInfo
{
    public function __construct(
        public string $id,
        public string $name,
        public Address $address,
        public int $price,
        public Currency $currency,
    ) {
    }
}
