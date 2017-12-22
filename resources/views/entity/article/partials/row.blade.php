<tr>
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
    <td class="">
        <strong>{{_i('Author')}}:</strong> <a
                href="{{action('UserController@show', $article->author)}}">{{$article->author->name}}</a>
    </td>

    @if($article->pivot->accepted)
        <td>
            <span class="text-success">
                {{_i('Accepted')}}
            </span>
        </td>
    @else
        <td></td>
    @endif


    <td class="">
        @if($article->google_id)
            <strong>{{_i('Google docs')}}:</strong> <a target="_blank"
                                                       href="https://docs.google.com/document/d/{{$article->google_id}}/edit">{{_i('open')}}</a>
        @endif
    </td>
    <td class="project-actions">
        <a href="{{action('ProjectController@show', ['id' => $article->id])}}" class="btn btn-white btn-sm">
            <i class="fa fa-folder"></i> {{_i('View')}}
        </a>
    </td>
</tr>