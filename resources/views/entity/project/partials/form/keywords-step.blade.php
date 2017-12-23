<div class="row text-center">
    <h3>{{_i('Form')}}</h3>
</div>


<div class="row p-h-lg">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-lg-2 control-label">Field 1</label>
            <div class="col-lg-10">
                <input type="text" class="form-control">
                <span class="help-block m-b-none">Descirption</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Field 2</label>
            <div class="col-lg-10">
                <input type="text" class="form-control">
                <span class="help-block m-b-none">Descirption</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Field 2</label>
            <div class="col-lg-10">
                <input type="text" class="form-control">
                <span class="help-block m-b-none">Descirption</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Field 2</label>
            <div class="col-lg-10">
                <input type="text" class="form-control">
                <span class="help-block m-b-none">Descirption</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Field 2</label>
            <div class="col-lg-10">
                <input type="text" class="form-control">
                <span class="help-block m-b-none">Descirption</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Field 2</label>
            <div class="col-lg-10">
                <input type="text" class="form-control">
                <span class="help-block m-b-none">Descirption</span>
            </div>
        </div>
    </div>
</div>


<div class="row text-center">
    <h3>{{_i('Keywords')}}</h3>
</div>

<div class="row">
    <div class="form-group">
        <div class="col-lg-1">
            <label for="input-{{str_replace(' ', '', $theme)}}"
                   class="control-label">{{_i('Add keyword manually')}}
            </label>
        </div>
        <div class="col-lg-4">
            <input data-theme="{{$theme}}" id="input-{{str_replace(' ', '', $theme)}}" type="text"
                   class="form-control keyword-input">
        </div>
        <div class="col-lg-2">
            <button data-theme="{{$theme}}"
                    id="keyword-input-submit-{{str_replace(' ', '', $theme)}}"
                    class="form-control btn-primary btn keyword-input-submit">
                {{_i('Add')}}
            </button>
        </div>
    </div>
</div>

<div class="row p-h-lg">
    <div data-theme="{{$theme}}" id="wrapper-{{str_replace(' ', '', $theme)}}"
         class="col-xs-12 col-sm-12 col-md-12 col-lg-12 keywords-wrapper">


        @foreach($keywords as $keyword => $accepted)
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="i-checks">
                    <label>
                        <input class="keywords-checkbox"
                               {{($accepted)?'checked':''}}
                               type="checkbox"
                               name="keywords[{{$theme}}][{{$keyword}}]"
                               value="true"> <i></i>
                        {{ucfirst($keyword)}}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>


