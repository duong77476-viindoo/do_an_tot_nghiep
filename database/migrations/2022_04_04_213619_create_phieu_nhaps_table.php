<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhieuNhapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phieu_nhaps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nha_cung_cap_id')->unsigned();
            $table->foreign('nha_cung_cap_id')
                ->references('id')
                ->on('nha_cung_caps')
                ->onDelete('cascade');
            $table->string('name')->comment('Tên phiếu nhập');
            $table->text('content')->comment('Nội dung phiếu nhập');
            $table->decimal('tong_tien',14,2)->default(0);
            $table->enum('trang_thai',['Chưa xác nhận','Xác nhận']);
            $table->bigInteger('nguoi_lap_id')->unsigned();
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
        Schema::dropIfExists('phieu_nhaps');
    }
}
