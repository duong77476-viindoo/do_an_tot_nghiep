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
            $table->bigInteger('product_group_id')->unsigned();
            $table->foreign('product_group_id')
                ->references('id')
                ->on('product_groups')
                ->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('code');
            $table->string('name')->comment('ví dụ xiaomi redmi 9C 3GB-64GB');
            $table->integer('so_luong')->default(0);
            $table->integer('so_luong_da_ban')->default(0);
            $table->decimal('gia_ban',14,2)->default(0);
            $table->decimal('gia_canh_tranh',14,2)->default(0);
            $table->integer('views')->nullable();
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
