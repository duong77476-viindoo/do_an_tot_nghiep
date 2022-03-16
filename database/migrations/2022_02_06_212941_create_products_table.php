<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->bigInteger('product_line_id')->unsigned();
            $table->foreign('product_line_id')
                ->references('id')
                ->on('product_lines')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('code');
            $table->string('so_luong');
            $table->string('so_luong_da_ban');
            $table->string('mo_ta_ngan_gon');
            $table->text('mo_ta_chi_tiet');
            $table->string('meta_keywords');
            $table->tinyInteger('ban_chay');
            $table->tinyInteger('noi_bat');
            $table->tinyInteger('moi_ve');
            $table->tinyInteger('trang_thai');
            $table->tinyInteger('an_hien');
            $table->double('gia_ban');
            $table->double('gia_canh_tranh');
            $table->string('anh_dai_dien')->default('no-image.jpeg');
            $table->bigInteger('brand_id')->unsigned();
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onDelete('cascade');
            $table->bigInteger('video_id')->unsigned();
            $table->foreign('video_id')
                ->references('id')
                ->on('videos')
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
        Schema::dropIfExists('products');
    }
}
