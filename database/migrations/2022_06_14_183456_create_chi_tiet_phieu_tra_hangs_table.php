<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiTietPhieuTraHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_phieu_tra_hangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('phieu_tra_hang_id')->unsigned();
            $table->foreign('phieu_tra_hang_id')
                ->references('id')
                ->on('phieu_tra_hangs')
                ->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->decimal('gia_xuat',14,2);
            $table->integer('so_luong_trong_don_hang')->default(0);
            $table->integer('so_luong_thuc_tra')->default(0);
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
        Schema::dropIfExists('chi_tiet_phieu_tra_hangs');
    }
}
