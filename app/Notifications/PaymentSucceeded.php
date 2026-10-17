<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSucceeded extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public float $amountPaid
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Payment Received for #{$this->order->order_number}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("We've received your payment of **$" . number_format($this->amountPaid, 2) . "**.")
            ->line("Your order is now being processed.")
            ->action('View Order', url("/api/orders/{$this->order->id}"))
            ->line('Thank you!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'payment_succeeded',
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'amount_paid'  => $this->amountPaid,
            'message'      => "Payment of \${$this->amountPaid} received for {$this->order->order_number}.",
        ];
    }
}