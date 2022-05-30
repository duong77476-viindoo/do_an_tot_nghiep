<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiTietPhieuNhapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_phieu_nhaps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('phieu_nhap_id')->unsigned();
            $table->foreign('phieu_nhap_id')
                ->references('id')
                ->on('phieu_nhaps')
                ->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->decimal('gia_nhap',14,2);
            $table->integer('so_luong_yeu_cau')->default(0);
            $table->integer('so_luong_thuc_nhap')->default(0);
            $table->decimal('thanh_tien',14,2)->default(0);
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
        Schema::dropIfExists('chi_tiet_phieu_nhaps');
    }
}
