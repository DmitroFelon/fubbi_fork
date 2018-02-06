<tr class="pointer" onclick="window.location='{{action('Resources\ProjectController@show', [$project])}}'">
    <td class="project-status">
        <span class="label label-primary">{{ucfirst(str_replace('_',' ',$project->state))}}</span>
    </td>
    <td class="project-title">
        <a href="{{action('Resources\ProjectController@show', [$project])}}">{{$project->name}}</a>
        <br/>
        <small>
            {{_i('Created')}} {{$project->created_at->format('Y-m-d')}}
        </small>
    </td>
    <td class="">
        <strong>{{_i('Client')}}:</strong> {{$project->client->name}}
    </td>
    <td class="project-completion">
        <small>{{_i('Completion with')}}: {{$project->getProgress()}}%</small>
        <div class="progress progress-mini">
            <div style="width: {{$project->getProgress()}}%;" class="progress-bar"></div>
        </div>
    </td>
    <td class="project-completion">
        <strong>{{_i('Articles')}}:</strong> {{_i('Total')}}:{{$project->articles()->count()}}, {{_i('Accepted')}}
        :{{$project->articles()->accepted()->count()}}
    </td>
    <td>
        @if($project->subscription->onGracePeriod())
            <strong>{{_i('Will be stopped at')}}:</strong> {{$project->subscription->ends_at->format('Y-m-d')}}
        @endif
    </td>
    <td class="project-actions">
        <a href="{{action('Project\ArticlesController@index', [$project])}}" class="btn btn-white btn-sm blue-bg">
            <i class="fa fa-folder"></i> {{_i('Content')}}
        </a>
        <a href="{{action('Resources\ProjectController@export', $project)}}" class="btn btn-white btn-sm yellow-bg">
            <i class="fa fa-download"></i> {{_i('Export')}}
        </a>
        @role([\App\Models\Role::ADMIN, \App\Models\Role::CLIENT])
        <a href="{{action('Resources\MessageController@index', ['c' => $project->conversation_id])}}"
           class="btn btn-white btn-sm lazur-bg">
            <i class="fa fa-cloud"></i> {{_i('Chat')}}
        </a>
        @if($project->subscription->onGracePeriod())
            <a href="{{action('Resources\ProjectController@resume', $project)}}" class="btn btn-white btn-sm grey-bg">
                <i class="fa fa-refresh"></i> {{_i('Resume')}}
            </a>
        @else
            <form method="post" style="display:inline;"
                  action="{{action('Resources\ProjectController@destroy', [$project])}}">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button class="btn btn-white btn-sm red-bg" type="submit"><i class="fa fa-trash"></i> {{_i('Delete')}}
                </button>
            </form>
        @endif
        @endrole()

    </td>
</tr>