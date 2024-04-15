<?php

namespace App\Notifications;

use App\Models\Biro;
use App\Settings\GeneralSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationNotificationManagement extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Biro $biro) {}

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
        return (new MailMessage)
                    ->line('Terdapat Pendaftaran Biro Baru dengan nama ' . $this->biro->name . ' yang perlu ditinjau.') 
                    ->action('Ke Halaman Admin', url('/admin/biros'))
                    ->line('Terima kasih telah menggunakan aplikasi kami');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
