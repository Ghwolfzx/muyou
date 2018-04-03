@if(!empty($resource) && $resource != '[]')

    <div class="panel panel-default topic-reply">
        @foreach ($resource as $index => $val)
            <div class="panel-body">
                <a href="{{ route('resource.show', $val->id) }}"><img src="{{ $val->simg_url }}"></a>
            </div>
        @endforeach
    </div>
@endif