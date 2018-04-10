<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Topic;
use App\Models\Department;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorizationRequest;

class ApiController extends Controller
{
    // 登录
    // public function store(AuthorizationRequest $request) {

    //     $username = $request->username;

    //     filter_var($username, FILTER_VALIDATE_EMAIL) ?
    //         $credentials['email'] = $username :
    //         $credentials['name'] = $username;

    //     $credentials['password'] = $request->password;

    //     if (Auth::attempt($credentials)) {
    //         return ['status' => true, 'msg' => '登录成功'];
    //     } else {
    //         return ['status' => false, 'msg' => '登录失败'];
    //     }
    // }

    // 查看所有项目
    public function index(Category $category)
    {
        if(!empty($category->id)) {

            $departments = Department::select('id', 'name')->orderBy('id')->get();

            return $departments;
        } else {

            $category = $category->select('id', 'name', 'img')->orderBy('id')->get();
            return $category;
        }
    }

    // 查看项目下所有部门
    public function show(Category $category, Department $department, Request $request)
    {
        $user_ids = DB::table('user_has_departments')->where(['category_id' => $category->id, 'department_id' => $department->id])->pluck('user_id')->toArray();
        $users = User::whereIn('id', $user_ids)->select('id', 'name', 'introduction', 'avatar')->get();
        $topics = [];
        foreach ($users as $user) {
            $userTopic = $user->topics()->select('id', 'title', 'user_id', 'excerpt')->where(['category_id' => $category->id, 'department_id' => $department->id, 'status' => 1])->get();
            foreach ($userTopic as &$topic) {
                $topic->img_url = '';
                $topic->simg_url = '';
                // 获取单个资源
                $resource = $topic->resource()->orderBy('id', 'desc')->select('img_url', 'simg_url')->first();
                if (!empty($resource)) {
                    $topic->img_url = $resource->img_url;
                    $topic->simg_url = $resource->simg_url;
                }
            }
            $topics = array_merge($topics, $userTopic->toArray());
        }

        return compact('topics', 'users');
    }

    // 人物详情
    public function users(Category $category, Department $department, User $user, Request $request)
    {
        $topics = $user->topics()->select('id', 'title', 'user_id', 'excerpt')->where(['category_id' => $category->id, 'department_id' => $department->id, 'status' => 1])->get();

        return compact('user', 'topics');
    }

    public function topics(Category $category, Department $department, User $user, Topic $topic, Request $request)
    {
        $resources = $topic->resource()->where(['status' => 1])->groupBy('type')->orderBy('id', 'desc')->get();

        return compact('topic', 'resources');
    }

    public function resources(Category $category, Department $department, User $user, Topic $topic, $resource, Request $request)
    {
        $resources = $topic->resource()->where('status', 1)->orderBy('id', 'desc');
        if($resource != 'all') {
            $resources->where('type', $resource);
        }
        $resources = $resources->get();

        return compact('resources');
    }
}
