<form method="post" class="row">
    {{ csrf_field() }}
    <div class="row">
        <h3>Keywords</h3>
        <div id="exTab2" class="container">
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
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <input class="form-control btn btn-primary" value="Create Project" type="submit">
    </div>
</form>