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

<hr>

<div class="row">
    <div class="col-lg-4">
        <dl class="dl-horizontal">
            <dt>{{_i('Articles')}}:</dt>
            <dd>
                {{$project->articles->count()}} -
                <a class="btn btn-xs btn-primary" href="{{action('Project\ArticlesController@index', [$project])}}">{{_i('Review')}}</a>
            </dd>
        </dl>
    </div>
    <div class="col-lg-4">
        <dl class="dl-horizontal">
            <dt>{{_i('Accepted')}}:</dt>
            <dd>
                {{$project->articles()->accepted()->count()}} - <a class="btn btn-xs btn-primary"
                        href="{{action('Project\ArticlesController@index', [$project, 'status' => '1'])}}">{{_i('Review')}}</a>
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
                        {{$project->getArticleByType($service)->count()}} - <a class="btn btn-xs btn-primary"
                                href="{{action('Project\ArticlesController@index', [$project, 'type' => $service])}}">{{_i('Review')}}</a>
                    </dd>
                </dl>
            </div>
            <div class="col-lg-4">
                <dl class="dl-horizontal">
                    <dt>{{_i('Accepted')}}:</dt>
                    <dd>
                        {{$project->getArticleByType($service)->accepted()->count()}} - <a class="btn btn-xs btn-primary"
                                href="{{action('Project\ArticlesController@index', [$project, 'type' => $service, 'status' => '1'])}}">{{_i('Review')}}</a>
                    </dd>
                </dl>
            </div>
        </div>
    @endif
@endforeach
