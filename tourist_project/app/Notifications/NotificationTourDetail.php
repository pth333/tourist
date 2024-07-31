<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Tour;
use Illuminate\Support\Carbon;

class NotificationTourDetail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $order;
    private $tran;
    public function __construct($order, $tran)
    {
        $this->order = $order;
        $this->tran = $tran;
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
            ->greeting('Xin chào quý khách!')
            ->line('Thông tin chi tiết chuyến đi của: ' . $this->order->tour->name_tour)
            ->line('Di chuyển bằng ' . $this->order->tour->type_vehical . ' từ ' . $this->order->tour->departure . ' vào ngày ' . Carbon::parse($this->order->tour->departure_day)->format('d/m/Y') )
            ->line('Xe sẽ đưa đón trả khách bằng: ' . $this->order->tour->type_vehical . ' về ' . $this->order->tour->destination . ' vào ngày ' . Carbon::parse($this->order->tour->return_day)->format('d/m/Y'))
            ->line('Số tiền quý khách đã thanh toán: ' . number_format($this->tran->total_tran) . 'VNĐ')
            ->line('Cảm ơn quý khách đã sử dụng dịch vụ, nụ cười của quý khách là niềm vui của chúng tôi ^-^');
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
