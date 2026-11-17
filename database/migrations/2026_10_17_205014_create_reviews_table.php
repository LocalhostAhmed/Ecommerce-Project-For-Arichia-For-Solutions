<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // 1–5 integer
            $table->tinyInteger('rating')->unsigned();

            $table->string('title', 150)->nullable();
            $table->text('comment')->nullable();

            // Auto-set when we detect a delivered/paid order for this product.
            $table->boolean('is_verified_purchase')->default(false);

            // Moderation: pending | approved | rejected
            $table->string('status', 20)->default('pending');

            $table->text('moderation_note')->nullable();
            $table->foreignId('moderated_by')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();
            $table->timestamp('moderated_at')->nullable();

            // Helpful votes (optional but common).
            $table->integer('helpful_count')->default(0);

            $table->timestamps();

            // One review per user per product.
            $table->unique(['product_id', 'user_id']);

            $table->index(['product_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
