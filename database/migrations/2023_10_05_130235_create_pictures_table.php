<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',32)->default('')->comment('标题');
            $table->string('sub_title',64)->default('')->comment('副标题');
            $table->string('description')->default('')->comment('描述');
            $table->integer('user_id')->comment('创建者ID');
            $table->tinyInteger('status')->default(0)->comment('状态，1-开启，0-关闭');
            $table->unique(['title']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pictures');
    }
}
