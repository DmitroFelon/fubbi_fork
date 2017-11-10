<ul class="nav nav-tabs">
    @for($i=1;$i<9;$i++)
        <li class="{{($i==1)?'active':''}}">
            <a href="#keyword-{{$i}}" data-toggle="tab">Overview {{$i}}</a>
        </li>
    @endfor
</ul>
<div class="tab-content clearfix">
    @for($i=1;$i<9;$i++)
        <div class="tab tab-pane {{($i==1)?'active':''}}" id="keyword-{{$i}}">
            @foreach(array_chunk($keywords, 10)[$i] as $keyword)
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <label>
                        <input name="keywords[]" type="checkbox" value="{{$keyword["text"]}}">
                        {{ucfirst($keyword["text"])}}
                    </label>
                </div>
            @endforeach
        </div>
    @endfor
</div>
