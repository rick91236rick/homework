<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateOrder
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly OrderRepository $orderRepository
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $currency = $event->order->currency->value;
        $function = "create{$currency}Order";
        $this->orderRepository->$function($event->order);
    }
}
