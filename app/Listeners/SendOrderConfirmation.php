<?php

namespace App\Listeners;

use App\Models\Order;
use App\Mail\LockoutMail;
use App\Events\OrderCreated;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderConfirmation
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
    public function handle(OrderCreated $event): void
    {
        Mail::to('arojas@cantv.com.ve')->send(new LockoutMail($event->orders));

    }
}
