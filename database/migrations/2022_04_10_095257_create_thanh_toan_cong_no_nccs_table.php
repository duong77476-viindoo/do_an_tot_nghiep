<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThanhToanCongNoNccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thanh_toan_cong_no_nccs', function (Blueprint $table) {
            $table->id();
            $table->text('noi_dung');
            $table->decimal('so_tien',14,2);
            $table->boolean('da_thanh_toan');
            $table->bigInteger('nguoi_lap_id')->unsigned();
            $table->foreign('nguoi_lap_id')
                ->references('id')
                ->on('admins')
                ->onDelete('cascade');
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
        Schema::dropIfExists('thanh_toan_cong_no_nccs');
    }
}
