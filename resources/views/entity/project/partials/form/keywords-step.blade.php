<div class="row text-center">
    <h3>{{_i('Form')}}</h3>
</div>


<div class="row p-h-lg">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label for="meta-{{str_replace(' ', '_', $theme)}}-content_theme"
                   class="col-lg-2 control-label">
                {{_i('Content theme')}}
            </label>
            <div class="col-lg-10">
                <input value="{{$meta->get('content_theme')}}" id="meta-{{str_replace(' ', '_', $theme)}}-content_theme"
                       name="meta[{{$theme}}][content_theme]"
                       type="text"
                       class="form-control">
                <span class="help-block">Descirption</span>
            </div>
        </div>
        <div class="form-group">
            <label for="meta-{{str_replace(' ', '_', $theme)}}-points_cover" class="col-lg-2 control-label">
                {{_i('What points hould we cover in the content?')}}
            </label>
            <div class="col-lg-10">
                <input value="{{$meta->get('points_cover')}}" id="meta-{{str_replace(' ', '_', $theme)}}-points_cover"
                       name="meta[{{$theme}}][points_cover]"
                       type="text" class="form-control">
                <span class="help-block">Descirption</span>
            </div>
        </div>
        <div class="form-group">
            <label for="meta-{{str_replace(' ', '_', $theme)}}-points_avoid" class="col-lg-2 control-label">
                {{_i('What points hould we avoid in content?')}}
            </label>
            <div class="col-lg-10">
                <input value="{{$meta->get('points_avoid')}}" id="meta-{{str_replace(' ', '_', $theme)}}-points_avoid"
                       name="meta[{{$theme}}][points_avoid]"
                       type="text" class="form-control">
                <span class="help-block">Descirption</span>
            </div>
        </div>
        <div class="form-group">
            <label for="meta-{{str_replace(' ', '_', $theme)}}-references" class="col-lg-2 control-label">
                {{_i('Links to references')}}
            </label>
            <div class="col-lg-10">
                <input value="{{$meta->get('references')}}" id="meta-{{str_replace(' ', '_', $theme)}}-references"
                       name="meta[{{$theme}}][references]"
                       type="text" class="form-control">
                <span class="help-block">Descirption</span>
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
            <input required data-theme="{{$theme}}" id="input-{{str_replace(' ', '', $theme)}}" type="text"
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
                               value="1"> <i></i>
                        {{ucfirst($keyword)}}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>


