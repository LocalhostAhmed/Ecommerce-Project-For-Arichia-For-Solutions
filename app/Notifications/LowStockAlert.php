<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Product $product
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $product = $this->product;

        return (new MailMessage)
            ->error()
            ->subject("Low Stock Alert: {$product->name}")
            ->greeting("Inventory Alert")
            ->line("Product **{$product->name}** is running low.")
            ->line("Current stock: **{$product->stock_quantity}**")
            ->line("Threshold: {$product->low_stock_threshold}")
            ->action('Restock Now', url("/admin/products/{$product->id}"))
            ->line('Please restock soon to avoid running out.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'                => 'low_stock_alert',
            'product_id'          => $this->product->id,
            'product_name'        => $this->product->name,
            'stock_quantity'      => $this->product->stock_quantity,
            'low_stock_threshold' => $this->product->low_stock_threshold,
            'message'             => "{$this->product->name} is low on stock ({$this->product->stock_quantity} left).",
        ];
    }
}