@foreach($keywords as $keyword)
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <label>
            <input name="keywords[]" type="checkbox" value="{{$keyword}}">
            {{ucfirst($keyword)}}
        </label>
    </div>
@endforeach
