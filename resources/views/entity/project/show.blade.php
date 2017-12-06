@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{__('Project details')}}</h2>
        </div>
    </div>

    @if(!$project->hasWorker() and \Illuminate\Support\Facades\Auth::user()->hasInvitetoProject($project->id) )
        @include('entity.project.partials.form.invite')
    @endif
@endsection

@section('content')
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-b-md">
                    @include('entity.project.partials.form.action-buttons')
                    <h2>{{$project->name}}</h2>
                </div>
                <div class="clear-both"></div>
                <dl class="dl-horizontal">
                    <dt>{{__('Status')}}:</dt>
                    <dd>
                    <span class="label label-primary">
                        {{ucfirst(str_replace('_',' ',$project->state))}}
                    </span>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <dl class="dl-horizontal">
                    <dt>Client:</dt>
                    <dd>
                        <a target="_blank" href="{{url()->action('UserController@show', $project->client)}}">
                            {{$project->client->name}}
                        </a>
                    </dd>
                    <dt>{{__('Subscription Plan')}}:</dt>
                    <dd>{{title_case(str_replace('-',' ',$project->subscription->stripe_plan))}}</dd>
                    <dt>{{__('Billing Cycle')}}:</dt>
                    <dd>1 {{__('month')}}</dd>
                    <dt>{{__('Messages')}}:</dt>
                    <dd>{{$project->commentCount()}}</dd>
                </dl>
            </div>
            <div class="col-lg-7" id="cluster_info">
                <dl class="dl-horizontal">
                    <dt>{{__('Last Updated')}}:</dt>
                    <dd>
                        {{$project->updated_at}}
                        <small class="text-muted">({{$project->updated_at->diffForHumans()}})</small>
                    </dd>
                    <dt>{{__('Created')}}:</dt>
                    <dd>
                        {{$project->created_at}}
                        <small class="text-muted">({{$project->created_at->diffForHumans()}})</small>
                    </dd>
                    <dt>{{__('Participants')}}:</dt>
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
                                    @each('entity.project.partials.files-row', $project->getMedia($collection), 'media', 'entity.project.partials.files-row-empty')
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