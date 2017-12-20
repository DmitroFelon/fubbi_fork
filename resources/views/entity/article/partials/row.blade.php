<tr>
    <td class="project-title">
        <a href="{{action('Project\ArticlesController@show', [$project, $article])}}">{{$article->title}}</a>
        <br/>
        <small>
            {{_i('Created')}} {{$article->created_at->format('Y-m-d H:m')}}
        </small>
    </td>
    <td class="">
        <strong>{{_i('Author')}}:</strong> {{$article->author->name}}
    </td>


    <td class="">
        @if($article->google_id)
            <strong>{{_i('Google docs')}}:</strong> <a target="_blank"
                                                       href="https://docs.google.com/document/d/{{$article->google_id}}/edit">{{_i('open')}}</a>
        @endif
    </td>


    <td class="project-actions">
        <a href="{{action('ProjectController@show', ['id' => $article->id])}}" class="btn btn-white btn-sm">
            <i class="fa fa-folder"></i> View
        </a>
    </td>
</tr>