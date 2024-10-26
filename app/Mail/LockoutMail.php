<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LockoutMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.lockout')
                    ->subject('Alerta de bloqueo de cuenta')
                    ->with(['ipAddress' => "244.178.44.111", 'date' => date("d/m/Y H:i:s")]);
    }
}