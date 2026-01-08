<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add product_id foreign key to orders table if not already there
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'product_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            });
        }

        // Update existing orders table to ensure proper FK
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                // Ensure total_price is decimal for proper currency handling
                $table->decimal('total_price', 10, 2)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'product_id')) {
                $table->dropForeignIdFor('Product');
                $table->dropColumn('product_id');
            }
        });
    }
};
