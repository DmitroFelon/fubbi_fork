<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{_i('Project in progress')}}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row m-t-md">
                <div class="col-lg-3">
                    <dl class="dl-horizontal">
                        <dt>{{_i('Articles')}}:</dt>
                        <dd>
                            {{$project->articles->count()}} - <a
                                    href="{{action('Project\ArticlesController@index', [$project])}}">{{_i('Review')}}</a>
                        </dd>
                    </dl>
                </div>
                <div class="col-lg-3">
                    <dl class="dl-horizontal">
                        <dt>{{_i('Accepted Articles')}}:</dt>
                        <dd>
                            {{$project->articles()->accepted()->count()}} - <a
                                    href="{{action('Project\ArticlesController@index', [$project])}}">{{_i('Review')}}</a>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>