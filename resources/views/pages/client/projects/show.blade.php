@extends('master')

@section('content')


    <div class="row">
        <h3>Project Quiz</h3>
    </div>
    <div>
        @foreach($project->getMeta() as $meta_key => $meta_value)
            @if($meta_value == '' or empty($meta_value) or is_object($meta_value))
                @continue
            @endif

            @if(is_array($meta_value))
                <div class="row">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a data-toggle="collapse" href="#{{$meta_key}}">{{ title_case( str_replace('_', ' ', $meta_key)) }}</a>
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
    </div>

    <div class="row">
        <h3>Media Files</h3>
    </div>


    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#media_collection">Media Collection</a>
            </div>
            <div id="media_collection" class="panel-collapse collapse">
                @foreach(\App\Models\Project::$media_collections as $collection)
                    <div class="row text-center">
                        <strong>{{title_case(str_replace('_',' ',$collection))}}</strong>
                    </div>
                    @foreach($project->getMedia($collection) as $media)
                        <img class="img-thumbnail col col-lg-2 col-md-2" src="{{$media->getFullUrl()}}">
                    @endforeach


                @endforeach
            </div>
        </div>
    </div>



@endsection