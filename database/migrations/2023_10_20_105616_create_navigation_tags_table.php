<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationTagsTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->default(0)->comment('创建者Id');
            $table->string('name', 16)->default('')->comment('名称');
            $table->integer('use_num')->unsigned()->nullable()->default(0)->comment('被使用次数');
            $table->tinyInteger('status')->default(1)->nullable()->comment('状态, 1启用, 0禁用');
            $table->timestamps();
            $table->unique(['name']);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_tags');
    }
}
