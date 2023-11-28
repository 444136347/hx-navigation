<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',32)->default('')->comment('标题');
            $table->string('sub_title',64)->default('')->comment('副标题');
            $table->string('description')->default('')->comment('描述');
            $table->string('cover_at')->default('')->comment('文章封面图URL');
            $table->integer('content_id')->comment('内容分表ID');
            $table->integer('user_id')->comment('上传者ID');
            $table->tinyInteger('status')->default(0)->nullable()->comment('状态，1-开启，2-关闭');
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
        Schema::dropIfExists('articles');
    }
}
