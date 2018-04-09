@extends('layouts.app')

@section('content')

@if(!empty($resource) && $resource != '[]')

    <div class="panel panel-default topic-reply">
        <div class="panel-body" style="float: left;">
            @foreach ($resource as $index => $val)
                <img src="{{ $val->simg_url }}" style="margin: 7px;">
            @endforeach
        </div>
    </div>
@endif

@stop