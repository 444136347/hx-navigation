<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->nullable()->comment('类型：0-文本，1-json，2-颜色选择，3-编辑器，4-图片上传');
            $table->string('name',32)->comment('参数名称');
            $table->string('key',255)->comment('参数key');
            $table->string('string_value',255)->nullable()->comment('字符参数值，当参数值简单使用');
            $table->string('description',255)->nullable()->comment('参数描述');
            $table->text('text_value')->nullable()->comment('text参数值，当参数值负责使用');
            $table->integer('user_id')->comment('操作人id');
            $table->tinyInteger('status')->default(1)->nullable()->comment('状态, 1启用, 0禁用');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['key','name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_configs');
    }
}
