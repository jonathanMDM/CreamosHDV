<?php

namespace App\Notifications;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSaleNotification extends Notification
{
    use Queueable;

    protected $venta;

    /**
     * Create a new notification instance.
     */
    public function __construct(Venta $venta)
    {
        $this->venta = $venta;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $venta = $this->venta;
        $asesor = $venta->asesor;
        $servicio = $venta->servicio;
        
        $tipoPagoTexto = $venta->tipo_pago === 'pago_50' ? 'Pago 50%' : 'Pago Total';
        $appUrl = config('app.url') ?: 'https://creamos-hojas-de-vida-67e514fac37f.herokuapp.com';
        
        return (new MailMessage)
                    ->subject('🔔 Nueva Venta Registrada - ' . $asesor->nombre_completo)
                    ->greeting('¡Hola Administrador!')
                    ->line('Se ha registrado una nueva venta que requiere tu revisión.')
                    ->line('**Detalles de la Venta:**')
                    ->line('👤 **Asesor:** ' . $asesor->nombre_completo)
                    ->line('📋 **Servicio:** ' . $servicio->nombre_servicio)
                    ->line('💵 **Valor:** $' . number_format($venta->valor_servicio, 0, ',', '.'))
                    ->line('💰 **Comisión:** $' . number_format($venta->comision, 0, ',', '.'))
                    ->line('💳 **Tipo de Pago:** ' . $tipoPagoTexto)
                    ->line('📅 **Fecha:** ' . $venta->created_at->format('d/m/Y H:i'))
                    ->line($venta->image_url ? '📸 **Comprobante:** Adjunto' : '⚠️ **Sin comprobante**')
                    ->action('Ver Detalles de la Venta', $appUrl . '/ventas/' . $venta->id)
                    ->line('Por favor, revisa y aprueba esta venta lo antes posible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
