<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationSiteCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_site_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default('0')->comment('上级id');
            $table->string('title',32)->default('')->comment('标题');
            $table->string('icon')->default('')->nullable()->comment('图标');
            $table->string('description')->default('')->nullable()->comment('描述');
            $table->integer('order')->default('0')->nullable()->comment('排序');
            $table->integer('user_id')->comment('创建者ID');
            $table->tinyInteger('depth')->default('1')->comment('层级');
            $table->string('status')->default(0)->comment('状态，1-开启，0-关闭');
            $table->unique(['title']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_site_categories');
    }
}
