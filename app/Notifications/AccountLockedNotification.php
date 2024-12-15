<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AccountLockedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * El usuario que recibe la notificación.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Crear una nueva instancia de notificación.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Tu cuenta ha sido bloqueada')
            ->greeting('!Buen dia, ' . $this->user->name . '!')
            ->line('Tu cuenta ha sido bloqueada debido a múltiples intentos fallidos de inicio de sesión.')
            ->line('Por favor, contacta al soporte si crees que esto es un error o para obtener más información.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}

