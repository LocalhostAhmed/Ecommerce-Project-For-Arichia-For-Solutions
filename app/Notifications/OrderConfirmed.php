<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url("/api/orders/{$this->order->id}");

        return (new MailMessage)
            ->subject("Order Confirmed #{$this->order->order_number}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your order **{$this->order->order_number}** has been confirmed.")
            ->line("Total: $" . number_format((float) $this->order->total_amount, 2))
            ->line("Items: {$this->order->items->count()}")
            ->action('View Order', $url)
            ->line('Thank you for shopping with ElectroHub!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'order_confirmed',
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'total_amount' => (float) $this->order->total_amount,
            'message'      => "Your order {$this->order->order_number} has been confirmed.",
        ];
    }
}