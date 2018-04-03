@extends('layouts.app')

@section('content')

@if(!empty($resource) && $resource != '[]')

    <div class="panel panel-default topic-reply">
        @foreach ($resource as $index => $val)
            <div class="panel-body" style="float: left;">
                <img src="{{ $val->simg_url }}">
            </div>
        @endforeach
    </div>
@endif

@stop