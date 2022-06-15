<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductIdentitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_identities', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('trang_thai',['Chưa xuất','Đã xuất','Đã hủy'])->default('Chưa xuất');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->bigInteger('phieu_nhap_id')->unsigned();
            $table->foreign('phieu_nhap_id')
                ->references('id')
                ->on('phieu_nhaps')
                ->onDelete('cascade');
            $table->bigInteger('phieu_xuat_id')->unsigned();
            $table->foreign('phieu_xuat_id')
                ->references('id')
                ->on('phieu_xuats')
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
        Schema::dropIfExists('product_identities');
    }
}
