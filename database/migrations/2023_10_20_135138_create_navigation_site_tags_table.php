<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationSiteTagsTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_site_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned()->comment('标签ID');
            $table->integer('site_id')->unsigned()->comment('导航网站ID');
            $table->unique(['tag_id', 'site_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_site_tags');
    }
}
