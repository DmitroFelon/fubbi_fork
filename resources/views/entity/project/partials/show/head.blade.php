<div class="row">
    <div class="col-lg-12">
        <div class="clear-both"></div>
        <dl class="dl-horizontal">
            <dt>{{_i('Status')}}:</dt>
            <dd>
                    <span class="label label-primary">
                        {{ucfirst(str_replace('_',' ',$project->state))}}
                    </span>
            </dd>
        </dl>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <dl class="dl-horizontal">
            <dt>Client:</dt>
            <dd>
                <a target="_blank" href="{{url()->action('UserController@show', $project->client)}}">
                    {{$project->client->name}}
                </a>
            </dd>
            <dt>{{_i('Subscription Plan')}}:</dt>
            <dd>
                {{title_case(str_replace('-',' ',$project->subscription->stripe_plan))}}
                @if(!$project->getModifications()->isEmpty())
                    <small>({{_i('modified')}})</small>
                @endif
            </dd>
            <dt>{{_i('Billing Cycle')}}:</dt>
            <dd>1 {{_i('month')}}</dd>
        </dl>
    </div>
    <div class="col-lg-4" id="cluster_info">
        <dl class="dl-horizontal">
            <dt>{{_i('Last Updated')}}:</dt>
            <dd>
                {{$project->updated_at}}
                <small class="text-muted">({{$project->updated_at->diffForHumans()}})</small>
            </dd>
            <dt>{{_i('Created')}}:</dt>
            <dd>
                {{$project->created_at}}
                <small class="text-muted">({{$project->created_at->diffForHumans()}})</small>
            </dd>
            @if($project->workers->isNotEmpty())
                <dt>{{_i('Participants')}}:</dt>

                @foreach($project->workers as $worker)
                    <dd class="project-people">
                        <a target="_blank" href="{{url()->action('UserController@show', $worker)}}">
                            {{$worker->name}}
                        </a>
                    </dd>
                @endforeach

            @endif
            @if($project->teams->isNotEmpty())
                <dt>{{_i('Team')}}:</dt>

                @foreach($project->teams as $team)
                    <dd class="project-people">
                        <a target="_blank" href="{{url()->action('TeamController@show', $team)}}">
                            {{$team->name}}
                        </a>
                    </dd>
                @endforeach

            @endif
        </dl>
    </div>
    <div class="col-lg-4">
        <dl class="dl-horizontal">
            @foreach($project->plan_metadata as $key => $value)
                <dt>
                    {{ucwords( str_replace('_',' ',$key) )}}:
                </dt>
                <dd>
                    @if($project->isModified($key))
                        {{ (is_bool($project->getModified($key)))
                        ? ($project->getModified($key)) ?_i('Yes') : _i('No') : $project->getModified($key)  }}
                    @else
                        {{ (is_bool($value)) ? ($value) ?_i('Yes') : _i('No') : $value  }}
                    @endif
                </dd>
            @endforeach
        </dl>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <dl class="dl-horizontal">
            <dt>{{_i('Completed')}}:</dt>
            <dd>
                <div class="progress progress-striped active m-b-sm">
                    <div style="width: {{$project->getProgress()}}%;" class="progress-bar">
                        <span>{{$project->getProgress()}}%</span>
                    </div>
                </div>
            </dd>
        </dl>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <dl class="dl-horizontal">
            <dt>{{_i('Total Articles')}}:</dt>
            <dd>
                {{$project->articles->count()}} - <a
                        href="{{action('Project\ArticlesController@index', [$project])}}">{{_i('Review')}}</a>
            </dd>
        </dl>
    </div>
    <div class="col-lg-4">
        <dl class="dl-horizontal">
            <dt>{{_i('Accepted Articles')}}:</dt>
            <dd>
                {{$project->articles()->accepted()->count()}} - <a
                        href="{{action('Project\ArticlesController@index', [$project])}}">{{_i('Review')}}</a>
            </dd>
        </dl>
    </div>
</div>

@foreach($project->getVariableServices() as $service)
    @if($project->isRequireService($service))
        <div class="row">
            <div class="col-lg-4">
                <dl class="dl-horizontal">
                    <dt>{{$project->getServiceName($service)}}:</dt>
                    <dd>
                        {{$project->getArticleByType($service)->count()}} - <a
                                href="{{action('Project\ArticlesController@index', [$project])}}">{{_i('Review')}}</a>
                    </dd>
                </dl>
            </div>
            <div class="col-lg-4">
                <dl class="dl-horizontal">
                    <dt>{{_i('Accepted')}}:</dt>
                    <dd>
                        {{$project->getArticleByType($service)->accepted()->count()}} - <a
                                href="{{action('Project\ArticlesController@index', [$project])}}">{{_i('Review')}}</a>
                    </dd>
                </dl>
            </div>
        </div>
    @endif
@endforeach
