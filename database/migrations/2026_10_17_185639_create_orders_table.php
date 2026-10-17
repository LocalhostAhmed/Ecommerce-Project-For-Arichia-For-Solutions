<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Unique human-readable order number.
            $table->string('order_number', 32)->unique();

            // Prevent duplicate submissions.
            $table->string('idempotency_key', 64)->nullable()->unique();

            // Status transitions
            // pending → confirmed → processing → shipped → delivered
            // pending/confirmed → cancelled
            $table->string('status', 20)->default('pending');

            // ---- Totals (all stored as snapshots) ----
            $table->decimal('subtotal',       12, 2);
            $table->decimal('tax_amount',     12, 2)->default(0);
            $table->decimal('shipping_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount',   12, 2);

            // ---- Shipping address snapshot ----
            $table->string('shipping_name');
            $table->string('shipping_phone', 32);
            $table->string('shipping_email');
            $table->string('shipping_address_line1');
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code', 20);
            $table->string('shipping_country', 2);

            // ---- Billing info (optional, defaults to shipping) ----
            $table->boolean('billing_same_as_shipping')->default(true);

            // ---- Coupon snapshot ----
            $table->string('coupon_code', 64)->nullable();

            // ---- Payment (informational for now) ----
            $table->string('payment_method', 32)->default('cod');
            $table->string('payment_status', 20)->default('unpaid');

            // ---- Notes ----
            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};