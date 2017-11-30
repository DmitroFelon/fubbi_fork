@extends('master')


@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Project detail</h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="ibox-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-b-md">
                <a href="{{url()->action('ProjectController@edit', $project)}}" class="btn btn-white btn-xs pull-right">Edit project</a>

                <h2>{{$project->name}}</h2>
            </div>
            <dl class="dl-horizontal">
                <dt>Status:</dt>
                <dd><span class="label label-primary">{{ucfirst(str_replace('_',' ',$project->state))}}</span></dd>
            </dl>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <dl class="dl-horizontal">
                <dt>Client:</dt>
                <dd>{{$project->client->name}}</dd>
                <dt>Subscription Plan:</dt>
                <dd>{{title_case(str_replace('-',' ',$project->subscription->stripe_plan))}}</dd>
                <dt>Billing Cycle:</dt>
                <dd>1 {{__('month')}}</dd>
                <dt>Messages:</dt>
                <dd>{{$project->commentCount()}}</dd>
            </dl>
        </div>
        <div class="col-lg-7" id="cluster_info">
            <dl class="dl-horizontal">
                <dt>Last Updated:</dt>
                <dd>
                    {{$project->updated_at}}
                    <small class="text-muted">({{$project->updated_at->diffForHumans()}})</small>
                </dd>
                <dt>Created:</dt>
                <dd>
                    {{$project->created_at}}
                    <small class="text-muted">({{$project->created_at->diffForHumans()}})</small>
                </dd>
                <dt>Participants:</dt>
                <dd class="project-people">
                    @foreach($project->workers as $worker)
                        <div>
                            <a target="_blank" href="{{url()->action('UserController@show', $worker)}}">
                                {{$worker->name}}
                            </a>
                        </div>
                    @endforeach
                </dd>
            </dl>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <dl class="dl-horizontal">
                <dt>{{__('Completed')}}:</dt>
                <dd>
                    <div class="progress progress-striped active m-b-sm">
                        <div style="width: 0.5%;" class="progress-bar">
                           <span>0.5%</span>
                        </div>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
    {{--Metadata block start--}}
    <div class="panel panel-default">
        <div data-toggle="collapse" href="#meta_data" class="panel-heading clickable">
            <span class="text-center">{{__('Project quiz result')}}</span>
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