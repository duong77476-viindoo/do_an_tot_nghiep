<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhieuXuatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phieu_xuats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->default(null)->unsigned();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->enum('trang_thai',['Chờ xác nhận','Xác nhận'])->default('Chờ xác nhận');
            $table->string('name')->comment('Tên phiếu xuất');
            $table->text('content')->comment('Nội dung phiếu xuất');
            $table->decimal('tong_tien',14,2)->default(0);
            $table->enum('trang_thai',['Chưa xác nhận','Xác nhận']);
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
        Schema::dropIfExists('phieu_xuats');
    }
}
