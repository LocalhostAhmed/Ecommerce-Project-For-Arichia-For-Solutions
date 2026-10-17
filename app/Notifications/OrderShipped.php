<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShipped extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public ?string $trackingNumber = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject("Your Order #{$this->order->order_number} Has Shipped!")
            ->greeting("Good news, {$notifiable->name}!")
            ->line("Your order **{$this->order->order_number}** is on its way.");

        if ($this->trackingNumber) {
            $message->line("Tracking number: **{$this->trackingNumber}**");
        }

        return $message
            ->action('Track Order', url("/api/orders/{$this->order->id}/tracking"))
            ->line('Thank you for shopping with ElectroHub!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'            => 'order_shipped',
            'order_id'        => $this->order->id,
            'order_number'    => $this->order->order_number,
            'tracking_number' => $this->trackingNumber,
            'message'         => "Order {$this->order->order_number} has shipped.",
        ];
    }
}