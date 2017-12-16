<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{_i('Require')}}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
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
</div>


<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{_i('Completed')}}</h5>
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
