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
                        @foreach($project->getRequirements()->chunk(6) as $chunk)
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                @foreach($chunk as $row)
                                    <div class="i-checks">
                                        <label>
                                            <input tabindex="{{$loop->parent->index+$loop->index}}" type="checkbox"
                                                   required
                                                   name="c"
                                                   value="1"> <i></i>
                                            {{_i($row['string'])}}
                                        </label>
                                    </div>
                                    @if($row['media_collection'])
                                        <div class="well m-t-xs m-b-md">
                                            <h5><strong>{{_i('Files')}}:</strong></h5>
                                            @foreach($project->getMedia($row['media_collection']) as $media)
                                                <div class="border-bottom">
                                                    <a target="_blank"
                                                       href="{{$media->getFullUrl()}}">{{$media->getFullUrl()}}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if($row['meta_name'])
                                        <div class=" well m-t-xs m-b-md">
                                            <h5><strong>{{_i('Quiz result')}}:</strong></h5>
                                            @foreach(collect($project->{$row['meta_name']}) as $meta)
                                                <div class="border-bottom">
                                                    @if(filter_var($meta, FILTER_VALIDATE_URL))
                                                        <a target="_blank" href="{{$meta}}">{{$meta}}</a>
                                                    @else
                                                        {{$meta}}
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-lg-offset-1 col-md-offset-1 m-t-md">
                        <h3 class="text-center">
                            {{_i('Content')}}
                        </h3>
                        {!! Form::bsSelect('type', $filters['types'], '', _i('Content Type'), null, ['required']) !!}
                        {!! Form::bsText('file', null, _i('Article File'), _i('Upload file'), [], 'file') !!}
                        {!! Form::bsText('copyscape', null, _i('Copyscape Screenshot'), _i('Upload Copyscape Screenshot'), [], 'file') !!}
                        {{--{!! Form::bsText('tags', null,_i("Tags"),_i("Separate by coma or click 'enter'."), ['required', 'class'=> 'tagsinput' ]) !!}--}}
                        {{Form::submit('Upload article', ['class' => 'btn btn-primary'])}}
                    </div>
                </div>


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