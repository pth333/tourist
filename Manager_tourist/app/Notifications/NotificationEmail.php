<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationEmail extends Notification
{
    use Queueable;
    public $user;
    public $url;
    /**
     * Create a new notification instance.
     */
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
        // dd($this->url);
        return (new MailMessage)
            ->greeting('Xin chào!'.' - '.$this->user->name)
            ->line('Tài khoản của bạn đã được đăng ký!')
            ->action('Xác minh tài khoản', $this->url)
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
