@foreach($keywords as $keyword)
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <label>
            <input {{($keyword['accepted'])?'checked':''}} name="keywords[{{$keyword['theme']}}]" type="checkbox" value="{{$keyword['text']}}">
            {{ucfirst($keyword['text'])}}
        </label>
    </div>
@endforeach
