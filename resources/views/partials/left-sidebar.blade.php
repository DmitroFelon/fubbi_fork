<ul class="list-group">
    @foreach($items as $name => $link)
        <a class="list-group-item {{(Request::is(ltrim($link, '/')))?'active':''}}" href="{{$link}}">{{$name}}</a>
    @endforeach
</ul>

