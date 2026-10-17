<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Denormalized average rating (1.00–5.00), only approved reviews.
            $table->decimal('rating', 3, 2)->default(0)->after('stock_quantity');

            // Number of approved reviews.
            $table->integer('rating_count')->default(0)->after('rating');

            $table->index('rating');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['rating']);
            $table->dropColumn(['rating', 'rating_count']);
        });
    }
};
