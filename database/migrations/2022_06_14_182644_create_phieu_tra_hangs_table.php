<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhieuTraHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phieu_tra_hangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->default(null)->unsigned();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->text('content')->comment('Nội dung phiếu trả hàng');
            $table->decimal('tong_tien',14,2)->default(0);
            $table->enum('trang_thai',['Chưa xác nhận','Xác nhận'])->default('Chưa xác nhận');
            $table->bigInteger('nguoi_lap_id')->default(null)->unsigned();
            $table->foreign('nguoi_lap_id')
                ->references('id')
                ->on('admins')
                ->onDelete('cascade');
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
        Schema::dropIfExists('phieu_tra_hangs');
    }
}
