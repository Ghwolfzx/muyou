<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Topic;
use App\Models\Category;
use App\Models\Department;
use App\Models\Link;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic, User $user, Link $link)
    {
        $topics = $topic->withOrder($request->order)->where('status', 1)->paginate(20);
        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();

        return view('topics.index', compact('topics', 'active_users', 'links'));
    }

    public function show(Request $request, Topic $topic)
    {
        // URL 矫正
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
    {
        $categories = Category::all();
        $departments = Department::all();
        return view('topics.create_and_edit', compact('topic', 'categories', 'departments'));
    }

	public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        return redirect()->to($topic->link())->with('success', '成功创建话题！');
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // dd($request->type_id);
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }

        // 资源上传
        if ($file = $request->upload_resource) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_resource, 'resource/'.\Auth::id(), \Auth::id(), false, 200);
            // 图片保存成功的话
            if ($result) {
                $id = Resource::create(['img_url' => $result['path'], 'simg_url' => $result['thumb_path'], 'type' => $request->type_id, 'topic_id' => $request->topic_id]);
                $data['file_path'] = $result['path'];
                $data['r_id'] = $id->id;
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }

	public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        $departments = Department::all();
        return view('topics.create_and_edit', compact('topic', 'categories', 'departments'));
    }

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

        if (!empty($request->r_id)) {
            Resource::whereIn('id', explode(',', $request->r_id))->update(['status' => 1]);
        }

		return redirect()->to($topic->link())->with('message', '更新成功！');
	}

    // 追加资源
    public function appendResource(Topic $topic)
    {
        $this->authorize('update', $topic);

        $resource = $topic->resource()->where('status', 1)->orderBy('type', 'desc')->first();
        $type = 1;
        if (isset($resource->type)) {
            $type = $resource->type + 1;
        }

        return view('topics.append_resource', compact('topic', 'type'));
    }

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
        $topic->status = 0;
		$topic->save();

		return redirect()->route('topics.index')->with('message', '成功删除！');
	}
}