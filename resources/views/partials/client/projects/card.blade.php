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
                {{$worker->name}}
            </a>
        @endforeach
    </td>
    <td class="project-actions">

        <a href="{{action('ProjectController@show', ['id' => $project->id])}}" class="btn btn-white btn-sm">
            <i class="fa fa-folder"></i> View
        </a>
        @role('client)
        <a href="{{action('ProjectController@edit', ['id' => $project->id])}}" class="btn btn-white btn-sm">
            <i class="fa fa-pencil"></i> Edit
        </a>
        @endrole
    </td>
</tr>