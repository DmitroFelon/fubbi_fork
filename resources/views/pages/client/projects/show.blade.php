@extends('master')

@section('content')
    {{--Metadata block start--}}
    @foreach($project->getMeta() as $meta_key => $meta_value)
        @if($meta_value == '' or empty($meta_value) or is_object($meta_value))
            @continue
        @endif

        @if(is_array($meta_value))
            <div class="row">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse"
                               href="#{{$meta_key}}">{{ title_case( str_replace('_', ' ', $meta_key)) }}</a>
                        </div>
                        <div id="{{$meta_key}}" class="panel-collapse collapse">
                            <ul>
                                @foreach($meta_value as $sub_key => $sub_value)
                                    @isset($sub_value)
                                    <li>
                                        <strong>
                                            {{ (is_int($sub_key))?'':title_case( str_replace('_', ' ', $sub_key)) }}
                                        </strong>
                                        {!! $sub_value !!}
                                    </li>
                                    @endisset
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <strong>{{ title_case( str_replace('_', ' ', $meta_key)) }}:</strong>
                {!!  $meta_value  !!}
            </div>
        @endif
    @endforeach
    {{--Metadata block end--}}

    {{--Media block start--}}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#media_collection">Media Collection</a>
            </div>
            <div id="media_collection" class="panel-collapse">
                @foreach(\App\Models\Project::$media_collections as $collection)
                    @if(!$project->hasMedia($collection)) @continue @endif
                    <div class="row">
                        <div class="col col-xs-12">
                            <h3 class="text-center">{{title_case(str_replace('_',' ',$collection))}}</h3>
                            @foreach($project->getMedia($collection) as $media)
                                <div class="col col-xs-3">
                                    <div class="file-box">
                                        <div class="file">
                                            <span class="corner"></span>
                                            <div class="icon">
                                                @if($media->mime_type == 'image/jpeg')
                                                    <a href="{{$media->getFullUrl()}}"
                                                       target="_blank"
                                                       data-gallery="{{$collection}}">
                                                        <img class="blueimp-gallery-image"
                                                             src="{{$media->getFullUrl()}}">
                                                    </a>
                                                @else
                                                    <a target="_blank" href="{{$media->getFullUrl()}}">
                                                        <i class="fa fa-file"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="file-name">
                                                <a target="_blank" href="{{$media->getFullUrl()}}">
                                                    {{$media->file_name}}
                                                </a>
                                                <br/>
                                                <small>Added: {{$media->created_at->format('Y-m-d')}}</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
    {{--Media block end--}}


    <style>
        .blueimp-gallery-image {
            height: 100%;
        }
    </style>


@endsection