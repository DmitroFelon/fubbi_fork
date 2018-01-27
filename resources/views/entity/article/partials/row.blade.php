<tr class="pointer"
    onclick="window.location='{{action('Project\ArticlesController@show', [$article->project, $article])}}'">
    <td class="project-title">
        <a href="{{action('Project\ArticlesController@show', [$article->project, $article])}}">{{$article->title}}</a>
        <br/>
        <small>
            {{_i('Created')}} {{$article->created_at->format('Y-m-d H:m')}}
        </small>
    </td>

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

    <td>
        <strong>{{_i('Type')}}:</strong> {{$article->type}}
    </td>

    <td>
        @if($article->ratingPercent > 0)
            <span class="ratable" data-rateyo-read-only="true"
                  data-rating="{{$article->ratingPercent}}"></span>
        @endif
    </td>

    <td>
        <strong>
            {{_i('Project')}}:
        </strong> <a href="{{action('ProjectController@show', $article->project)}}">"{{$article->project->name}}"</a>
    </td>

    <td>
        <strong>
            {{_i('This month')}}:
        </strong> {{($article->active) ? 'Yes' : 'No'}}
    </td>


</tr>