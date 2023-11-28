<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitPagesTable extends Migration
{
    public function up()
    {
        Schema::create('visit_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 32)->default('')->comment('访问标题');
            $table->string('tag', 20)->default('')->comment('访问tag');
            $table->string('status')->default('')->comment('状态，1-开启，0-关闭');
            $table->timestamps();
            $table->unique(['tag']);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visit_pages');
    }
}
