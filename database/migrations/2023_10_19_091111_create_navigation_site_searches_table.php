<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationSiteSearchesTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_site_searches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keyword',32)->comment('搜索关键字');
            $table->integer('order')->default(0)->nullable()->comment('排序');
            $table->integer('num')->default(0)->nullable()->comment('搜索次数');
            $table->tinyInteger('is_hot')->default(0)->comment('是否是热门搜索，0-否，1-是');
            $table->string('status')->default(0)->comment('状态，1-开启，0-关闭');
            $table->unique(['keyword']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_site_searches');
    }
}
