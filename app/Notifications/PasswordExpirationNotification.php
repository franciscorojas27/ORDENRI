<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PasswordExpirationNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    // Enviar la notificación por correo
    /**
     * The function generates an email message reminding the user to update their password within 30
     * days to avoid access restrictions.
     * 
     * @param notifiable The `notifiable` parameter in the `toMail` function represents the entity or
     * model that will receive the email notification. In this case, it seems like the `notifiable`
     * parameter is not being used directly within the function, but it is typically used to retrieve
     * information about the recipient of the
     * 
     * @return MailMessage object is being returned with a subject, greeting, message lines, an
     * action button to update the password, and a closing line.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Tu contraseña será bloqueada en 30 días')
            ->greeting('Hola, ' . $this->user->name)
            ->line('¡Atención! Tu contraseña será bloqueada en los próximos 30 días. Para evitar interrupciones en tu acceso, te recomendamos actualizarla lo antes posible.')

            ->action('Actualizar Contraseña', url('/reset-password/' . $this->user->generateToken() . '?email=' . urlencode($this->user->email)))
            ->line('Si no realizas esta acción, tu acceso será restringido.');
    }

    // Enviar la notificación por base de datos
    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'message' => 'Tu contraseña será bloqueada en los próximos 30 días. Actualiza la cuanto antes.',
            'expire_at' => now()->addDays(30),
        ]);
    }

    // Usar el canal adecuado para enviar la notificación (correo, base de datos)
    public function via($notifiable)
    {
        return ['mail'];
    }
}
