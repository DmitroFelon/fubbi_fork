
@role(['admin', 'account_manager'])
    @include('entity.project.tabs.quiz')
    @include('entity.project.tabs.keywords')
@endrole


@role(['client'])
    @switch($step)
    @case(\App\Models\Helpers\ProjectStates::PLAN_SELECTION)
        @include('entity.project.tabs.plan')
        @break
    @case(\App\Models\Helpers\ProjectStates::QUIZ_FILLING)
        @include('entity.project.tabs.quiz')
        @break
    @case(\App\Models\Helpers\ProjectStates::KEYWORDS_FILLING)
        @include('entity.project.tabs.keywords')
        @break
    @case(\App\Models\Helpers\ProjectStates::MANAGER_REVIEW)
        <div class="text-primary">
            {{_i('Project is on manager review.')}}
        </div>
        @break
    @case(\App\Models\Helpers\ProjectStates::PROCESSING)
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('We are working on your project')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <dl class="dl-horizontal">
                        @foreach($project->plan_metadata as $key => $value)
                            @if(in_array($key, $project->getCountableServices()))
                                <dt>
                                    {{ucwords( str_replace('_',' ',$key) )}}:
                                </dt>
                                <dd>
                                    <a>{{_i('Outlines')}} : {{$project->getServiceOutlines($key)->count()}} </a>
                                    /
                                    <a>{{_i('Completed')}}: {{$project->getServiceResult($key)->count()}} </a>
                                </dd>
                            @else
                                <dt>{{ucwords( str_replace('_',' ',$key) )}}:</dt>
                                <dd>-</dd>
                            @endif

                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
    @break
    @case(\App\Models\Helpers\ProjectStates::ACCEPTED_BY_MANAGER)
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('We are working on your project')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <dl class="dl-horizontal">
                        @foreach($project->plan_metadata as $key => $value)
                            @if(in_array($key, $project->getCountableServices()))
                                <dt>
                                    {{ucwords( str_replace('_',' ',$key) )}}:
                                </dt>
                                <dd>
                                    <a>{{_i('Outlines')}} : {{$project->getServiceOutlines($key)->count()}} </a>
                                    /
                                    <a>{{_i('Completed')}}: {{$project->getServiceResult($key)->count()}} </a>
                                </dd>
                            @else
                                <dt>{{ucwords( str_replace('_',' ',$key) )}}:</dt>
                                <dd>-</dd>
                            @endif

                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
        @break

    @default
        impossible state
    @endswitch
@endrole



