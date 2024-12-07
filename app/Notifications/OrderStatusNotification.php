<?php
namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $status = $this->order->status->status;
        $isSupervisor = $notifiable->isSupervisor() || $notifiable->isAdmin();
        $actionRoute = $isSupervisor
            ? route('order.edit', $this->order)
            : route('order.show', $this->order);


        // Determinamos el mensaje según el estado de la orden
        if ($status === 'Pendiente') {
            return (new MailMessage)
                ->subject("Nueva Orden de Servicio #{$this->order->id} - Pendiente de Resolución")
                ->greeting(' ') // Elimina el saludo predeterminado "¡Hola!"
                ->line("La Orden #{$this->order->id} ha sido registrada y está en espera de resolución.")
                ->line("Detalles de la orden:")
                ->line("- **Fecha de creación**: {$this->order->created_at}")
                ->line("- **Cliente**: {$this->order->client->name} {$this->order->client->last_name}")
                ->line("- **Tipo de Orden**: {$this->order->type->type}")
                ->line("- **Descripción**: {$this->order->client_description}")
                ->line("- **Área de resolución**: {$this->order->resolutionArea->area}")
                ->line("La orden está pendiente de ser asignada para su resolución.")
                ->line('Para más detalles, accede al sistema y consulta el estado completo de la orden.')
                ->action('Ver detalles de la orden', $actionRoute)
                ->line('Gracias por utilizar nuestro sistema de gestión de órdenes de servicio.');
        }

        if ($status === 'Finalizada') {
            return (new MailMessage)
                ->subject("Orden de Servicio #{$this->order->id} - Finalizada.")
                ->greeting(' ') // Elimina el saludo "¡Hola!"
                ->line("La Orden #{$this->order->id} ha sido **finalizada**.")
                ->line("Detalles de la resolución:")
                ->line("- **Tipo de Orden**: {$this->order->type->type}")
                ->line("- **Fecha de inicio**: {$this->order->start_at}")
                ->line("- **Fecha de finalización**: {$this->order->end_at}")
                ->line("- **Analista encargado**: {$this->order->applicantTo->name} {$this->order->applicantTo->last_name}")
                ->line("- **Área de resolución**: {$this->order->resolutionArea->area}")
                ->line("- **Descripción de la resolución**: {$this->order->description}")
                ->line("La orden ha sido resuelta y está disponible para su consulta.")
                ->line('Para más detalles, accede al sistema y consulta el estado completo de la orden.')
                ->action('Ver detalles de la orden', $actionRoute)
                ->line('Gracias por utilizar nuestro sistema de gestión de órdenes de servicio.');
        }
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status->status,
        ];
    }
}