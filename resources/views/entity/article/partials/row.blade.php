<tr class="pointer" onclick="window.location='{{action('Project\ArticlesController@show', [$project, $article])}}'">
    @isset($project)
    @if($article->accepted === 1)
        <td>
            <span class="badge badge-primary p-xs">{{_i('Accepted')}}</span>
        </td>
    @elseif($article->accepted === 0)
        <td>
            <span class="badge badge-danger p-xs">{{_i('Rejected')}}</span>
        </td>
    @else
        <td>
            <span class="badge p-xs">{{_i('New')}}</span>
        </td>
    @endif
    @endisset

    <td class="project-title">
        @if(isset($project))
            <a href="{{action('Project\ArticlesController@show', [$project, $article])}}">{{$article->title}}</a>
        @else
            <a href="{{action('ArticlesController@show', [$article])}}">{{$article->title}}</a>
        @endif

        <br/>
        <small>
            {{_i('Created')}} {{$article->created_at->format('Y-m-d H:m')}}
        </small>
    </td>

    <td>
        <strong>{{_i('Type')}}:</strong> {{$article->type}}
    </td>

    <td>
        @isset($project)
        <strong>
            {{_i('Project')}}:
        </strong> <a href="{{action('ProjectController@show', $project)}}">"{{$project->name}}"</a>
        @endisset
    </td>

</tr>