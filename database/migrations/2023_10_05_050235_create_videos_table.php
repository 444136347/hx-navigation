<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',32)->default('')->comment('标题');
            $table->string('sub_title',64)->default('')->comment('副标题');
            $table->string('description')->default('')->comment('描述');
            $table->integer('user_id')->comment('创建者ID');
            $table->tinyInteger('status')->default(0)->comment('状态，1-开启，0-关闭');
            $table->string('video_at')->default('')->comment('视频链接');
            $table->string('cover_at')->default('')->comment('封面链接');
            $table->double('seconds')->default(0)->nullable()->comment('视频秒数');
            $table->unique(['title']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
