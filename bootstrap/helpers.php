<?php

// 根据浏览器返回类名
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

// 对内容进行处理
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}