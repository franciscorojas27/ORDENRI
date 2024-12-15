<?php

namespace App\Listeners;

use App\Mail\LockoutMail;
use App\Events\OrderCreated;
use Illuminate\Support\Facades\Mail;

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
    
        Mail::raw('prueba de correo', function ($message) {
            $message->subject('Correo de prueba');
            $message->from('arojas@cantv.com.ve', 'Sistema de pedidos');
            $message->to('arojas@cantv.com.ve');
        });

    }
}
