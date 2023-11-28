<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePictureAttachmentTable extends Migration
{
    public function up()
    {
        Schema::create('picture_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('picture_id')->unsigned()->comment('图集ID');
            $table->string('url', 255)->comment('附件链接');
            $table->string('desc',255)->comment('附件描述');
            $table->integer('order')->default('0')->nullable()->comment('排序');
            $table->index(['picture_id']);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('picture_attachments');
    }
}
