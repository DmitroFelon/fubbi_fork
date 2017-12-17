@foreach($keywords as $keyword => $accepted)
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="i-checks">
            <label>
                <input
                        class="keywords-checkbox"
                        {{($accepted)?'checked':''}}
                        type="checkbox"
                        name="keywords[{{$theme}}][{{$keyword}}]"
                        value="true"> <i></i>
                {{ucfirst($keyword)}}
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
