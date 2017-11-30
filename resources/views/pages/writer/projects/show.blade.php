@extends('master')

@section('content')
    <div class="ibox-content">
    {{--Metadata block start--}}
    <div class="panel panel-default">
        <div data-toggle="collapse" href="#meta_data" class="panel-heading clickable">
            <span class="text-center">{{__('Project "%s" Quiz result',$project->name)}}</span>
            <i class="pull-right fa fa-expand" aria-hidden="true"></i>
        </div>
        <div id="meta_data" class="panel-collapse panel-body collapse">
            @foreach($project->getMeta() as $meta_key => $meta_value)
                @if($meta_value == '' or empty($meta_value) or is_object($meta_value))
                    @continue
                @endif
                @if(is_array($meta_value) and !empty($meta_value))
                    <div>
                        <h4>{{ title_case( str_replace('_', ' ', $meta_key)) }}</h4>
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
                @else
                    <div>
                        <strong>{{ title_case( str_replace('_', ' ', $meta_key)) }}:</strong>
                        {!!  $meta_value  !!}
                    </div>
                @endif
                @if(!$loop->last)
                    <hr>
                @endif

            @endforeach
        </div>
    </div>

    {{--Metadata block end--}}

    {{--Media block start--}}

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div data-toggle="collapse" href="#media_collection" class="panel-heading clickable">
                    <span class="text-center">{{__('Attached media files')}}</span>
                    <i class="pull-right fa fa-expand" aria-hidden="true"></i>
                </div>
                <div id="media_collection" class="panel-collapse panel-body collapse">
                    @foreach(\App\Models\Project::$media_collections as $collection)
                        @if(!$project->hasMedia($collection)) @continue @endif
                        <div class="row">
                            <div class="col col-xs-12">
                                <h3 class="text-center">{{title_case(str_replace('_',' ',$collection))}}</h3>
                                @each('partials.client.project.files-row', $project->getMedia($collection), 'media', 'partials.client.project.form.plan.files-row-empty')
                            </div>

                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{--Media block end--}}
    </div>

@endsection