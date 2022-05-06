<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('shipping_id')->unsigned();
            $table->bigInteger('payment_id')->unsigned();
            $table->decimal('fee_ship',14,2)->default(0);
            $table->decimal('coupon',14,2)->default(0);
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->foreign('shipping_id')
                ->references('id')
                ->on('shippings')
                ->onDelete('cascade');
            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->onDelete('cascade');
            $table->integer('tong_so_luong')->default(0);
            $table->decimal('tong_tien',14,2)->default(0);
            $table->enum('trang_thai',['Đang chờ xử lý',
                'Đang xử lý','Đang giao hàng','Chờ xác nhận hủy','Đã hủy','Đã giao hàng']);
            $table->date('order_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
