@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <a href="{{action('ProjectController@show', $project)}}">
                    <h5>
                        {{_i('Upload article for project: ')}}
                        {{$project->name}}
                    </h5>
                </a>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                {{Form::open(['id' => 'article-form', 'enctype'=>"multipart/form-data",  'role'=>'form', 'multipart', 'route'=>['project.articles.store', $project->id] ])}}
                <div class="bg-muted p-sm">
                    <h3>
                        {{_i('Checklist')}}
                    </h3>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Have you checked the compliance document?')}}
                                </label>
                            </div>
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Have you checked the client’s preferred writing style?')}}
                                </label>
                            </div>
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Have you checked the Preferred Language?')}}
                                </label>
                            </div>
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Did you study the client’s model articles?')}}
                                </label>
                            </div>
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Did you add the client’s preferred call to action?')}}
                                </label>
                            </div>
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Did you check if the content needs to be relvant to a City, State or Country?')}}
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Did you check the Words To Avoid list?')}}
                                </label>
                            </div>
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Did you check the Writing Guidelines List?')}}
                                </label>
                            </div>
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Did you check every point in the outline is covered in the article?')}}
                                </label>
                            </div>
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Did you only only write one article this month per keyword?')}}
                                </label>
                            </div>
                            <div class="i-checks">
                                <label>
                                    <input type="checkbox"
                                           required
                                           name="c"
                                           value="1"> <i></i>
                                    {{_i('Did you lay the article out in the correct format?')}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::bsText('title', null, _i('Title'), null, ['required'], 'text') !!}
                {!! Form::bsSelect('type', ['' => 'Select Type', 'Article Outline' => 'Article Outline', 'Article Topic' => 'Article Topic', 'Article' => 'Article', 'Social Posts Texts' => 'Social Posts Texts'], '', _i('Content Type'), null, ['required']) !!}
                {!! Form::bsText('file', null, _i('Article File'), _i('Upload file to Google Docs. Keep empty to create a new file'), [], 'file') !!}
                {!! Form::bsText('copyscape', null, _i('Copyscape Screenshot'), _i('Upload Copyscape Screenshot if necessary'), [], 'file') !!}
                {!! Form::bsText('tags', null,_i("Tags"),_i("Separate by coma or click 'enter'."), ['required', 'class'=> 'tagsinput' ]) !!}
                {{Form::submit('Upload article', ['class' => 'form-control btn btn-primary'])}}
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">

        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type == "text")) {
                return false;
            }
        }

        document.onkeypress = stopRKey;

    </script>

@endsection