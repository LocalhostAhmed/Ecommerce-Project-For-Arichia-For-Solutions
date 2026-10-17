<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentFailed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $reason = 'Unknown error'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->error()
            ->subject("Payment Failed for #{$this->order->order_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your payment for order **{$this->order->order_number}** could not be processed.")
            ->line("Reason: {$this->reason}")
            ->action('Try Again', url("/api/orders/{$this->order->id}"))
            ->line('If the problem persists, please contact support.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'payment_failed',
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'reason'       => $this->reason,
            'message'      => "Payment failed for {$this->order->order_number}: {$this->reason}",
        ];
    }
}