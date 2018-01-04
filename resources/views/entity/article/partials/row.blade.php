<tr>

    @if(isset($article->pivot->accepted))
        @if($article->pivot->accepted === 1)
            <td>
                <span class="badge badge-primary">{{_i('Accepted')}}</span>
            </td>
        @elseif($article->pivot->accepted === 0)
            <td>
                <span class="badge badge-danger">{{_i('Rejected')}}</span>
            </td>
        @else
            <td>
                <span class="badge">{{_i('Review')}}</span>
            </td>
        @endif
    @else
        <td>
            <span class="badge">{{_i('Review')}}</span>
        </td>
    @endif


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
        <strong>{{_i('Author')}}:</strong> <a
                href="{{action('UserController@show', $article->author)}}">{{$article->author->name}}</a>
    </td>

    <td>
        <strong>{{_i('Type')}}:</strong> {{$article->type}}
    </td>

    <td>
        @if($article->google_id)
            <strong>{{_i('Google docs')}}:</strong> <a target="_blank"
                                                       href="https://docs.google.com/document/d/{{$article->google_id}}/edit">{{_i('open')}}</a>
        @else
            <strong>{{_i('Google docs')}}:</strong> {{ _i('Processing')}}
        @endif
    </td>
    <td class="project-actions">
        @if(isset($project))
            <a href="{{action('Project\ArticlesController@show', [$project, $article])}}"
               class="btn btn-white btn-sm">
                <i class="fa fa-folder"></i> {{_i('View')}}
            </a>
        @else
            <a href="{{action('ArticlesController@show', [$article])}}" class="btn btn-white btn-sm">
                <i class="fa fa-folder"></i> {{_i('View')}}
            </a>
        @endif

    </td>
</tr>