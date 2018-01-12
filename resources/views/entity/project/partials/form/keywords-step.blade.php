<div class="row text-center">
    <h3>{{_i('Form')}}</h3>
</div>

<div class="row p-h-lg">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <input value="no" name="meta[{{$theme}}][this_month]" type="hidden"/>
        <input value="no" name="meta[{{$theme}}][next_moth]" type="hidden"/>
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
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="meta-{{str_replace(' ', '_', $theme)}}-points_cover" class="col-lg-2 control-label">
                {{_i('What points should we cover in the content?')}}
            </label>
            <div class="col-lg-10">
                <input value="{{$meta->get('points_cover')}}" id="meta-{{str_replace(' ', '_', $theme)}}-points_cover"
                       name="meta[{{$theme}}][points_cover]"
                       type="text" class="form-control">
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="meta-{{str_replace(' ', '_', $theme)}}-points_avoid" class="col-lg-2 control-label">
                {{_i('What points should we avoid in content?')}}
            </label>
            <div class="col-lg-10">
                <input value="{{$meta->get('points_avoid')}}" id="meta-{{str_replace(' ', '_', $theme)}}-points_avoid"
                       name="meta[{{$theme}}][points_avoid]"
                       type="text" class="form-control">
                <span class="help-block"></span>
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
                <span class="help-block"></span>
            </div>
        </div>
        <br>
        <div class="form-group m-t-md">
            <label for="meta-{{str_replace(' ', '_', $theme)}}-this_month" class="col-lg-2 control-label">
                {{_i('Write about topic this month?')}}
            </label>
            <div class="col-lg-10">

                <input id="meta-{{str_replace(' ', '_', $theme)}}-this_month" name="meta[{{$theme}}][this_month]"
                       {{($meta->get('this_month') == 'yes') ? 'checked' : ''}}
                       type="checkbox" value="yes" class="js-switch"/>
                <span class="help-block"></span>
            </div>
        </div>
        <br>
        <div class="form-group m-t-md">
            <label for="meta-{{str_replace(' ', '_', $theme)}}-next_moth" class="col-lg-2 control-label">
                {{_i('Write about topic next month?')}}
            </label>
            <div class="col-lg-10">

                <input id="meta-{{str_replace(' ', '_', $theme)}}-next_moth" name="meta[{{$theme}}][next_moth]"
                       {{($meta->get('next_moth') == 'yes') ? 'checked' : ''}}
                       type="checkbox" value="yes" class="js-switch"/>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group m-t-md">
            <label for="meta-{{str_replace(' ', '_', $theme)}}-next_moth" class="col-lg-2 control-label">
                {{_i('Files')}}
            </label>
            <div class="col-lg-10">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div data-theme="{{$theme}}" id="meta-{{str_replace(' ', '_', $theme)}}-files"
                         class="dropzone keyword-dropzone">
                    </div>
                </div>
                <span class="help-block"></span>
            </div>
            <script>
                var meta_dropzone_id = "meta-{{str_replace(' ', '_', $theme)}}-files";
                var meta_dropzone_collection = "meta-{{str_replace(' ', '_', $theme)}}-collection";
            </script>
        </div>
    </div>
</div>

<div class="row text-center">
    <h3>{{_i('Keywords')}}</h3>
</div>

<div class="tabs-container keyword-question">

    <ul class="nav nav-tabs">
        <li class="active">
            <a role="tab" aria-expanded="true" class="keyword-question-tab" data-toggle="tab"
               href="#tab-themes-{{str_replace(' ', '-', $theme)}}">
                {{_i('Keywords Suggestions')}}
            </a>
        </li>

        <li>
            <a role="tab" aria-expanded="false" class="keyword-question-tab" data-toggle="tab"
               href="#tab-questions-{{str_replace(' ', '-', $theme)}}">
                {{_i('Questions')}}
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" id="tab-themes-{{str_replace(' ', '-', $theme)}}" class="tab-pane active">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-lg-1">
                                    <label for="input-{{str_replace(' ', '', $theme)}}"
                                           class="control-label">{{_i('Add keyword manually')}}
                                    </label>
                                </div>
                                <div class="col-lg-4">
                                    <input required data-theme="{{$theme}}" id="input-{{str_replace(' ', '', $theme)}}"
                                           type="text"
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
                    </div>

                </div>
            </div>
        </div>

        <div role="tabpanel" id="tab-questions-{{str_replace(' ', '-', $theme)}}" class="tab-pane">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-lg-1">
                                    <label for="input-{{str_replace(' ', '', $theme)}}"
                                           class="control-label">{{_i('Add question manually')}}
                                    </label>
                                </div>
                                <div class="col-lg-4">
                                    <input required data-question-theme="{{$theme}}"
                                           id="input-{{str_replace(' ', '', $theme)}}"
                                           type="text"
                                           class="form-control keyword-input">
                                </div>
                                <div class="col-lg-2">
                                    <button data-question-theme="{{$theme}}"
                                            id="keyword-input-submit-{{str_replace(' ', '', $theme)}}"
                                            class="form-control btn-primary btn keyword-question-input-submit">
                                        {{_i('Add')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row p-h-lg">
                            <div data-question-theme="{{$theme}}" id="wrapper-{{str_replace(' ', '', $theme)}}"
                                 class="col-xs-12 col-sm-12 col-md-12 col-lg-12 keywords-wrapper">
                                @foreach($keywords_questions as $keyword => $accepted)
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="i-checks">
                                            <label>
                                                <input class="keywords-checkbox"
                                                       {{($accepted)?'checked':''}}
                                                       type="checkbox"
                                                       name="keywords_questions[{{$theme}}][{{$keyword}}]"> <i></i>
                                                {{ucfirst($keyword)}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>




