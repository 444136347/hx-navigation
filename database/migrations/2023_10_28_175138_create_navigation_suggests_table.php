<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationSuggestsTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_suggests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',32)->default('')->comment('推荐标题');
            $table->string('description',255)->default('')->comment('推荐描述');
            $table->string('keywords',255)->default('')->comment('推荐关键字');
            $table->string('classify',32)->default('')->comment('推荐归类,sites-网站，down-资源');
            $table->integer('category_id')->default(0)->nullable()->comment('分类ID');
            $table->string('link',255)->nullable()->comment('推荐链接');
            $table->string('submit_ip',255)->nullable()->comment('记录推荐ip');
            $table->text('data_json')->nullable()->comment('保存资源的一些信息');
            $table->tinyInteger('status')->default(0)->nullable()->comment('状态，1-开启，2-关闭');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_suggests');
    }
}
