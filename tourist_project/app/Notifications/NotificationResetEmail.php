<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationResetEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $user, $url;
    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
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
        return (new MailMessage)
            ->greeting('Xin chào!' . ' - ' . $this->user->name)
            ->line('Vui lòng click vào link bên dưới để xác minh!')
            ->action('Lấy lại mật khẩu', $this->url)
            ->line('Cảm ơn bạn đã sử dụng hệ thống của chúng tôi!');
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
