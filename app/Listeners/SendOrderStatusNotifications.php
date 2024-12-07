<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderStatusUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\OrderStatusNotification;

class SendOrderStatusNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order;
        
        $supervisor = User::find($order->applicant_to_id);
        $client = User::find($order->client_id);

        if ($supervisor) {
            $supervisor->notify(new OrderStatusNotification($order));
        }
        
        if ($client) {
            $client->notify(new OrderStatusNotification($order));
        }
    }
}
