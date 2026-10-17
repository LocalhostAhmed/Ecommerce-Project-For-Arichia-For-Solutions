<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $oldStatus,
        public string $newStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Order #{$this->order->order_number} — Status Updated")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your order status has changed from **{$this->oldStatus}** to **{$this->newStatus}**.")
            ->action('Track Order', url("/api/orders/{$this->order->id}/tracking"))
            ->line('Thank you for your patience!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'order_status_updated',
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status'   => $this->oldStatus,
            'new_status'   => $this->newStatus,
            'message'      => "Order {$this->order->order_number} is now {$this->newStatus}.",
        ];
    }
}