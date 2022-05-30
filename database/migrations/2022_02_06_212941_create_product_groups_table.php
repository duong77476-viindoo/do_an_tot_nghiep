<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_groups', function (Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('mo_ta_ngan_gon');
            $table->text('mo_ta_chi_tiet');
            $table->string('meta_keywords');
            $table->tinyInteger('ban_chay');
            $table->tinyInteger('noi_bat');
            $table->tinyInteger('moi_ve');
            $table->tinyInteger('trang_thai');
            $table->tinyInteger('an_hien');
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
            $table->bigInteger('nganh_hang_id')->unsigned();
            $table->foreign('nganh_hang_id')
                ->references('id')
                ->on('nganh_hangs')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_groups');
    }
}
