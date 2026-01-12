<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeAdvisorNotification extends Notification
{
    use Queueable;

    protected $password;
    protected $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
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
        $appUrl = config('app.url') ?: 'https://creamos-hojas-de-vida-67e514fac37f.herokuapp.com';
        
        return (new MailMessage)
                    ->subject('¡Bienvenido a CreamosHDV! - Tus Credenciales de Acceso')
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line('Te damos la bienvenida al equipo de CreamosHDV. Tu cuenta ha sido creada exitosamente.')
                    ->line('Aquí tienes tus credenciales para acceder al portal de asesores:')
                    ->line('**Correo Electrónico:** ' . $this->email)
                    ->line('**Contraseña:** ' . $this->password)
                    ->action('Ingresar al Portal', $appUrl . '/login')
                    ->line('Te recomendamos cambiar tu contraseña una vez que hayas ingresado por primera vez.')
                    ->line('¡Gracias por ser parte de nosotros!');
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
