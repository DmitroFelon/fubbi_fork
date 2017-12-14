@foreach($keywords as $keyword)
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div class="i-checks">
            <label>
                <input
                        class="keywords-checkbox"
                        {{($keyword['accepted'])?'checked':''}}
                        type="checkbox"
                        name="keywords[{{$keyword['theme']}}][{{$keyword['text']}}]"
                        value="true"> <i></i>
                {{ucfirst($keyword['text'])}}
            </label>
        </div>
    </div>
@endforeach
<script>
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
</script>
