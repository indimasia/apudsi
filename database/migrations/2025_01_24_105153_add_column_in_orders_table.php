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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('kurir');
            $table->dropColumn('quantity');
            $table->dropColumn('total_price');
            $table->foreignId('courier_id')->nullable()->constrained('couriers')->onDelete('set null')->after('product_id');
            $table->foreignId('order_payment_id')->nullable()->constrained('order_payments')->onDelete('set null')->after('courier_id');
            $table->string('payment_method');
            $table->string('payment_status')->default('pending');
            $table->timestamp('payment_due_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['courier_id']);
            $table->dropForeign(['order_payment_id']);
            $table->dropColumn(['courier_id', 'order_payment_id', 'payment_method', 'payment_status', 'payment_due_at']);
            $table->string('kurir');
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
        });
    }
};
