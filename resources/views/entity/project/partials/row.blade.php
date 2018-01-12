<tr>
    <td class="project-status">
        <span class="label label-primary">{{ucfirst(str_replace('_',' ',$project->state))}}</span>
    </td>
    <td class="project-title">
        <a href="{{action('ProjectController@show', ['id' => $project->id])}}">{{$project->name}}</a>
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
        @if($project->client->subscription($project->name)->onGracePeriod())
            <strong>{{_i('Will be stopped at')}}:</strong> {{$project->subscription->ends_at->format('Y-m-d')}}
        @endif
    </td>
    <td class="project-actions">
        <a href="{{action('ProjectController@show', ['id' => $project->id])}}" class="btn btn-white btn-sm navy-bg">
            <i class="fa fa-folder"></i> {{_i('View')}}
        </a>
        @role(\App\Models\Role::CLIENT)
        <a href="{{action('ProjectController@edit', ['id' => $project->id])}}" class="btn btn-white btn-sm blue-bg">
            <i class="fa fa-pencil"></i> {{_i('Edit')}}
        </a>
        @endrole
        <a href="{{action('ProjectController@export', $project)}}" class="btn btn-white btn-sm yellow-bg">
            <i class="fa fa-download"></i> {{_i('Export')}}
        </a>
        @role([\App\Models\Role::ADMIN, \App\Models\Role::CLIENT])
        @if($project->client->subscription( $project->name)->onGracePeriod())
            <a href="{{action('ProjectController@resume', $project)}}" class="btn btn-white btn-sm grey-bg">
                <i class="fa fa-refresh"></i> {{_i('Resume')}}
            </a>
        @else
            <form method="post" style="display:inline;"
                  action="{{action('ProjectController@destroy', ['id' => $project->id])}}">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button class="btn btn-white btn-sm red-bg" type="submit"><i class="fa fa-trash"></i> {{_i('Delete')}}
                </button>
            </form>
        @endif
        @endrole()
        <a href="{{action('MessageController@index', ['c' => $project->conversation_id])}}"
           class="btn btn-white btn-sm lazur-bg">
            <i class="fa fa-cloud"></i> {{_i('Chat')}}
        </a>
    </td>
</tr>