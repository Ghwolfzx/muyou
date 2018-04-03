<?php

use App\Models\Department;

return [
    'title'   => '部门',
    'single'  => '部门',
    'model'   => Department::class,

    // 对 CRUD 动作的单独权限控制，其他动作不指定默认为通过
    'action_permissions' => [
        // 删除权限控制
        'delete' => function () {
            // 只有站长才能删除话题分类
            return Auth::user()->hasRole('Founder');
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title'    => '名称',
            'sortable' => false,
        ],
        'description' => [
            'title'    => '描述',
            'sortable' => false,
        ],
        'category_id' => [
            'title'    => '项目',
            'sortable' => true,
            'select' => "IF((:table).category_id = 1, '作妖计', IF((:table).category_id = 2, '热血武道会', '乌龙院'))",
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name' => [
            'title' => '名称',
        ],
        'description' => [
            'title' => '描述',
            'type'  => 'textarea',
        ],
        'category_id' => [
            'title' => '所属项目',
            'type'  => 'enum',
            'options' => [
                '作妖计',
                '热血武道会',
                '乌龙院',
            ],
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '分类 ID',
        ],
        'name' => [
            'title' => '名称',
        ],
        'description' => [
            'title' => '描述',
        ],
        'category_id' => [
            'title' => '项目',
            'type'  => 'enum',
            'options' => [
                '作妖计',
                '热血武道会',
                '乌龙院',
            ],
        ],
    ],
    'rules'   => [
        'name' => 'required|min:1|unique:categories'
    ],
    'messages' => [
        'name.unique'   => '分类名在数据库里有重复，请选用其他名称。',
        'name.required' => '请确保名字至少一个字符以上',
    ],
];
