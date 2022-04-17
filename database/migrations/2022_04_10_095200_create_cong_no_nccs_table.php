<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCongNoNccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cong_no_nccs', function (Blueprint $table) {
            $table->id();
            $table->string('year',5);
            $table->string('month', 5);
            $table->decimal('cong_no_dau_thang',14,2);
            $table->decimal('cong_no_cuoi_thang',14,2);
            $table->decimal('cong_no_da_thanh_toan',14,2);
            $table->decimal('cong_no_con',14,2);
            $table->enum('trang_thai',['Chưa hoàn thành','Hoàn thành'])->default('Chưa hoàn thành');
            $table->bigInteger('nha_cung_cap_id')->unsigned();
            $table->foreign('nha_cung_cap_id')
                ->references('id')
                ->on('nha_cung_caps')
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
        Schema::dropIfExists('cong_no_nccs');
    }
}
