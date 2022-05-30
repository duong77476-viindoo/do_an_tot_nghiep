<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDacTinhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dac_tinhs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nganh_hang_id')->unsigned();
            $table->foreign('nganh_hang_id')
                ->references('id')
                ->on('nganh_hangs')
                ->onDelete('cascade');
            $table->string('name')->comment('ví dụ : ram,rom cho điện thoại/ GPU,CPU cho laptop');
            $table->string('code');
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
        Schema::dropIfExists('dac_tinhs');
    }
}
