<div class="row">
    <div class="col-lg-12">
        <div class="m-b-md">
            @include('entity.project.partials.show.action-buttons')
        </div>
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
    <div class="col-lg-5">
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
                @if($project->getModifications())
                    <small>({{_i('modified')}})</small>
                @endif
            </dd>
            <dt>{{_i('Billing Cycle')}}:</dt>
            <dd>1 {{_i('month')}}</dd>
            <dt>{{_i('Messages')}}:</dt>
            <dd>{{$project->commentCount()}}</dd>
        </dl>
    </div>
    <div class="col-lg-7" id="cluster_info">
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
            <dt>{{_i('Participants')}}:</dt>
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
            <dt>{{_i('Completed')}}:</dt>
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