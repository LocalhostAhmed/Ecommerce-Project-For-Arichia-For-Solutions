<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            // 'in', 'out', 'adjustment', 'set'
            $table->string('type', 20);

            // Positive for in, negative for out.
            $table->integer('quantity_change');

            // Snapshot of stock before and after.
            $table->integer('quantity_before');
            $table->integer('quantity_after');

            // Reason: 'manual', 'order', 'restock', 'damage', 'return', etc.
            $table->string('reason', 50)->default('manual');

            // Optional note.
            $table->string('note')->nullable();

            // Who did it (nullable — system actions have no user).
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['product_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};