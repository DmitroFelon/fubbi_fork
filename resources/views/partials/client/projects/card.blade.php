{{--
<div class="project-card col-xs-3 col-sm-3 col-md-3 col-lg-3">
    <div class="ibox">
        <div class="ibox-content product-box active">
            <div class="product-imitation">
                {{$project->name}}
            </div>
            <div class="product-desc">
                <span class="product-price">{{$project->state}}</span>
                <small class="text-muted">Category</small>
                <a href="#" class="product-name">Project</a>
                <div class="small m-t-xs">Some project description</div>
                <div class="m-t text-righ">
                    <a href="{{action('ProjectController@show', ['id' => $project->id])}}" class="btn btn-sm btn-outline btn-primary">
                        Review <i class="fa fa-long-arrow-right"></i>
                    </a>
                    <a href="{{action('ProjectController@edit', ['id' => $project->id])}}" class="btn btn-sm btn-outline btn-primary pull-right">
                        Edit <i class="fa fa-pencil"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>--}}


<tr>
    <td class="project-status">
        <span class="label label-primary">{{$project->state}}</span>
    </td>
    <td class="project-title">
        <a href="{{action('ProjectController@show', ['id' => $project->id])}}">{{$project->name}}</a>
        <br/>
        <small>
            Created {{$project->created_at->format('Y-m-d')}}
        </small>
    </td>
    <td class="project-completion">
        <small>Completion with: 48%</small>
        <div class="progress progress-mini">
            <div style="width: 48%;" class="progress-bar"></div>
        </div>
    </td>
    <td class="project-people">
        @foreach($project->workers as $worker)
            <a target="_blank" href="">
                {{--<img alt="image" class="img-circle" src="img/a3.jpg">--}}
                {{$worker->name}}
            </a>
        @endforeach
    </td>
    <td class="project-actions">
        <a href="{{action('ProjectController@show', ['id' => $project->id])}}" class="btn btn-white btn-sm">
            <i class="fa fa-folder"></i> View
        </a>
        <a href="{{action('ProjectController@edit', ['id' => $project->id])}}" class="btn btn-white btn-sm">
            <i class="fa fa-pencil"></i> Edit
        </a>
    </td>
</tr>