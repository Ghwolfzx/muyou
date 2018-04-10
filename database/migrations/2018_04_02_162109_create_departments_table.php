<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('category_id')->comment('所属项目');
            $table->string('name')->index()->comment('名称');
            $table->text('description')->nullable()->comment('描述');
            $table->integer('post_count')->default(0)->comment('帖子数');
            $table->timestamps();
        });



        $departments = [
            [
                'name'        => '原画',
                'description' => '原画',
            ],
            [
                'name'        => 'UI',
                'description' => 'UI',
            ],
            [
                'name'        => '场景',
                'description' => '场景',
            ],
            [
                'name'        => '特效',
                'description' => '特效',
            ],
            [
                'name'        => '动作',
                'description' => '动作',
            ],
            [
                'name'        => '宣传',
                'description' => '宣传',
            ],
            [
                'name'        => '视频',
                'description' => '视频',
            ],
            [
                'name'        => '漫画',
                'description' => '漫画',
            ],
        ];
        DB::table('departments')->insert($departments);
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
