<ul class="list-group">
    @foreach($items as $link => $name)
        <li class="list-group-item {{(Request::is($link))?'active':''}}" ><a href="{{$link}}">{{$name}}</a></li>
    @endforeach
</ul>

