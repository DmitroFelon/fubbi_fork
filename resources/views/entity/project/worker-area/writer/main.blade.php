<div class="row">
    <div class="col-lg-4">
        <h3 class="text-center">{{__('Require')}}</h3>
        <dl class="dl-horizontal">
            @foreach($project->plan_metadata as $key => $value)
                <dt>{{ucwords( str_replace('_',' ',$key) )}}:</dt>
                <dd>
                    {{$value}}
                </dd>
            @endforeach
        </dl>
    </div>
    <div class="col-lg-4">
        <h3 class="text-center">{{__('Completed')}}</h3>
        <dl class="dl-horizontal">
            @foreach($project->plan_metadata as $key => $value)
                <dt>{{ucwords( str_replace('_',' ',$key) )}}:</dt>
                <dd>

                </dd>
            @endforeach
        </dl>
    </div>
    <div class="col-lg-4">
        <h3 class="">{{__('create')}}</h3>
        <dl class="dl-horizontal">
            @foreach($project->plan_metadata as $key => $value)
                <dt>
                    <a href="#">{{__('add')}} {{ucwords( str_replace('_',' ',$key) )}}</a>
                </dt>
            @endforeach
        </dl>
    </div>
</div>