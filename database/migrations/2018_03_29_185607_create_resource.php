<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResource extends Migration
{
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('topic_id')->unsigned()->index();
            $table->string('img_url');
            $table->string('simg_url')->nullable();
            $table->integer('status')->default(0);
            $table->integer('type')->default(1);
            $table->timestamps();
        });

        Schema::table('resources', function (Blueprint $table) {

            // 当 topic_id 对应的 topics 表数据被删除时，删除此条数据
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('resources');
    }
}
