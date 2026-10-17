<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('label')->default('Home');
            $table->string('recipient_name');
            $table->string('phone', 30);

            $table->string('country', 100);
            $table->string('state', 100)->nullable();
            $table->string('city', 100);
            $table->string('street_address');
            $table->string('apartment')->nullable();
            $table->string('postal_code', 20)->nullable();

            $table->text('delivery_instructions')->nullable();

            $table->boolean('is_shipping')->default(true);
            $table->boolean('is_billing')->default(false);

            $table->boolean('is_default_shipping')->default(false);
            $table->boolean('is_default_billing')->default(false);

            $table->timestamps();

            $table->index(['user_id', 'is_shipping']);
            $table->index(['user_id', 'is_billing']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
