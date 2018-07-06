@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-body">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                        新建资源
                </h2>

                <hr>

                @include('common.error')

                <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                    <input type="hidden" name="_method" value="PUT">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" readonly />
                        <input type="hidden" name="category_id" value="{{ old('category_id', $topic->category_id ) }}" readonly />
                        <input type="hidden" name="department_id" value="{{ old('department_id', $topic->department_id ) }}" readonly />
                        <input type="hidden" name="body" value="{{ old('body', $topic->body ) }}" readonly />
                        <input type="hidden" name="r_id" id="r_id" value="" />
                        <input type="hidden" id="type_id" value="{{ $type }}" />
                    </div>

                    <div id="uploader" class="wu-example" data-topic="{{ $topic->id }}">
                        <div class="queueList">
                            <div id="dndArea" class="placeholder">
                                <div id="filePicker" class="webuploader-container">
                                    <div class="webuploader-pick">点击选择图片</div>
                                    <div id="rt_rt_1c9odk2evkfr9ossjk12pbg7f1" style="position: absolute; top: 0px; left: 448px; width: 168px; height: 44px; overflow: hidden; bottom: auto; right: auto;">
                                        <input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*">
                                        <label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label>
                                    </div>
                                </div>
                                <p>或将照片拖到这里，单次最多可选300张</p>
                            </div>
                        <ul class="filelist"></ul></div>
                        <div class="statusBar" style="display:none;">
                            <div class="progress" style="display: none;">
                                <span class="text">0%</span>
                                <span class="percentage" style="width: 0%;"></span>
                            </div><div class="info">共0张（0B），已上传0张</div>
                            <div class="btns">
                                <div id="filePicker2" class="webuploader-container">
                                    <div class="webuploader-pick">继续添加</div>
                                    <div id="rt_rt_1c9odk2f2gbbuau9np6lg1snc6" style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;">
                                        <input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*">
                                        <label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label>
                                    </div>
                                </div>
                                <div class="uploadBtn state-pedding">开始上传</div>
                            </div>
                        </div>
                    </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('webuploader/webuploader.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('webuploader/demo.css') }}?v1">
@stop

@section('scripts')
    <script type="text/javascript">
        var BASE_URL = '{{ asset('webuploader') }}';
        var csrf_token = '{{ csrf_token() }}';
        var UPLOAD_URL = '{{ route('topics.upload_image') }}';
    </script>
    <script type="text/javascript" src="{{ asset('webuploader/webuploader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webuploader/demo.js') }}?v15"></script>
@stop

@endsection
