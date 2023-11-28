<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationSitesTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('标题');
            $table->string('url')->default('')->comment('网址');
            $table->string('description')->default('')->comment('描述');
            $table->string('cover_at')->default('')->comment('封面图URL');
            $table->tinyInteger('show_outside')->default(0)->nullable()->comment('是否展示遮罩，一般是在微信浏览器内无法打开链接使用');
            $table->tinyInteger('content_type')->default(0)->nullable()->comment('内容类型，0-直接跳转,1-文章，2-图集，3-视频');
            $table->integer('content_id')->default(0)->comment('内容ID');
            $table->integer('category_id')->comment('分类ID');
            $table->integer('user_id')->comment('上传者ID');
            $table->integer('order')->default(0)->nullable()->comment('排序');
            $table->tinyInteger('status')->default(0)->nullable()->comment('状态，1-开启，2-关闭');
            $table->index(['title']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_sites');
    }
}
