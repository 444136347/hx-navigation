<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',32)->default('')->comment('轮播标题');
            $table->string('text',255)->default('')->comment('轮播文字');
            $table->string('link')->nullable()->comment('跳转链接');
            $table->string('description',255)->nullable()->comment('参数描述');
            $table->integer('order')->default(0)->nullable()->comment('排序');
            $table->integer('user_id')->comment('操作者用户ID');
            $table->tinyInteger('status')->default(0)->nullable()->comment('状态，1-开启，2-关闭');
            $table->unique(['title']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_messages');
    }
}
