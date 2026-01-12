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
                    ->subject('¡Bienvenido a CreamosHDV! 🎉 - Tus Credenciales de Acceso')
                    ->from('creamoshojasdevida@gmail.com', 'Creamos Hojas de Vida')
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line('¡Te damos la más cordial bienvenida al equipo de **Creamos Hojas de Vida**! 🎊')
                    ->line('')
                    ->line('Tu cuenta ha sido creada exitosamente y ya puedes acceder a nuestro portal de asesores.')
                    ->line('')
                    ->line('**📋 Tus credenciales de acceso:**')
                    ->line('')
                    ->line('🔐 **Correo Electrónico:** ' . $this->email)
                    ->line('🔑 **Contraseña:** `' . $this->password . '`')
                    ->line('')
                    ->line('⚠️ **Importante:** Por seguridad, te recomendamos cambiar tu contraseña una vez que ingreses por primera vez.')
                    ->action('🚀 Ingresar al Portal', $appUrl . '/login')
                    ->line('¡Gracias por ser parte de nuestro equipo!')
                    ->line('Estamos emocionados de trabajar contigo. 💼✨')
                    ->salutation('---  
**Creamos Hojas de Vida**  
© ' . date('Y') . ' Todos los derechos reservados.  
Desarrollado con ❤️ por [OutDeveloper](https://outdeveloper.com/)');
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
