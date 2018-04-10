<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    public function up()
    {
        $categories = [
            [
                'name'        => '作妖计',
                'description' => '作妖计',
                'img'         => config('app.url') . '/images/zuoyaoji.jpg',
            ],
            [
                'name'        => '热血武道会',
                'description' => '热血武道会',
                'img'         => config('app.url') . '/images/rexue.jpg',
            ],
            [
                'name'        => '乌龙院',
                'description' => '乌龙院',
                'img'         => config('app.url') . '/images/wulongyuan.jpg',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    public function down()
    {
        DB::table('categories')->truncate();
    }
}