@if(!empty($resource) && $resource != '[]')

    <div class="panel panel-default topic-reply">
        <div class="panel-body">
            @foreach ($resource as $index => $val)
                <a href="{{ route('resource.show', $val->id) }}" style="margin: 10px;"><img src="{{ $val->simg_url }}"></a>
            @endforeach
        </div>
    </div>
@endif