<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryProductProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_product_product_group', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_product_id')->unsigned();
            $table->bigInteger('product_group_id')->unsigned();
            $table->foreign('category_product_id')
                ->references('id')
                ->on('category_products')
                ->onDelete('cascade');
            $table->foreign('product_group_id')
                ->references('id')
                ->on('product_groups')
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
        Schema::dropIfExists('category_product_product_group');
    }
}
