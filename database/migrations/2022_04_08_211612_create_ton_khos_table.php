<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTonKhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ton_khos', function (Blueprint $table) {
            $table->id();
            $table->string('year',10)->comment('Năm');
            $table->string('month',10)->comment('Tháng');
            $table->integer('ton_dau_thang');
            $table->integer('nhap_trong_thang');
            $table->integer('xuat_trong_thang');
            $table->integer('ton');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.ta
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ton_khos');
    }
}
