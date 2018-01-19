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
<hr>
<div class="row">
    <div class="col-lg-4">
        <h3 class="m-b-md text-center">{{_i('Plan requirments')}}</h3>
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

            </dd>
            <dt>{{_i('Billing Cycle')}}:</dt>
            <dd>1 {{_i('month')}}</dd>
        </dl>
    </div>
    <div class="col-lg-4">
        <h3 class="m-b-md text-center">{{_i('Updates')}}</h3>
        <dl class="dl-horizontal">
            <dt>{{_i('Updated')}}:</dt>
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
                        @role([\App\Models\Role::ADMIN])
                        <a class="text-danger" title="Remove from project"
                           href="{{action('ProjectController@remove_from_project', [$project, $worker])}}">
                             <i class="fa fa-times"></i>
                        </a>
                        @endrole
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
        <h3 class="m-b-md text-center">{{_i('Plan requirments')}}</h3>
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
