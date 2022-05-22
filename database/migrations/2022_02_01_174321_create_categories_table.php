<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nganh_hang_id')->unsigned();
            $table->foreign('nganh_hang_id')
                ->references('id')
                ->on('nganh_hangs')
                ->onDelete('cascade');
            $table->string('name')->comment('Tên loại danh mục');
            $table->string('code');
            $table->text('desc');
            $table->smallInteger('status');
            $table->string('meta_keywords');
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
        Schema::dropIfExists('categories');
    }
}
