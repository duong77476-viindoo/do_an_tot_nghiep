<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_type_id')->unsigned();
            $table->foreign('post_type_id')
                ->references('id')
                ->on('post_types')
                ->onDelete('cascade');
            $table->string('code');
            $table->string('title')->comment('Tiêu đề bài viết');
            $table->string('desc')->comment('Mô tả ngắn gọn bài viét');
            $table->text('content')->comment('Nội dung bài viết');
            $table->smallInteger('status');
            $table->string('meta_keywords');
            $table->string('image');
            $table->string('nguoi_tao');
            $table->string('nguoi_sua');
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
        Schema::dropIfExists('posts');
    }
}
