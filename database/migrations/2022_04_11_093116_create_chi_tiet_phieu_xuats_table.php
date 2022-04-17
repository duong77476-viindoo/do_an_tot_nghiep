<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiTietPhieuXuatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_phieu_xuats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('phieu_xuat_id')->unsigned();
            $table->foreign('phieu_xuat_id')
                ->references('id')
                ->on('phieu_xuats')
                ->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->decimal('gia_xuat',14,2);
            $table->integer('so_luong_yeu_cau');
            $table->integer('so_luong_thuc_xuat');
            $table->decimal('thanh_tien',14,2);
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
        Schema::dropIfExists('chi_tiet_phieu_xuats');
    }
}
