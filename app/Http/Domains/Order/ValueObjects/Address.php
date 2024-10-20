<?php

namespace App\Http\Domains\Order\ValueObjects;


final readonly class Address
{
    public function __construct(
        public string $city,
        public string $district,
        public string $street,
    ) {
    }
}
