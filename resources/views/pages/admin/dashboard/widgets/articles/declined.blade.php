@if($declined_articles->isNotEmpty())
    <table class="table table-stripped table-hover small m-t-md">
        <tbody>
        @foreach($declined_articles as $article)
            <tr onclick="location.href='{{action('Project\ArticlesController@show', [$article->project->id, $article])}}';"
                class="clickable-row b-r-md">
                <td class="no-borders">
                    <i class="fa fa-circle text-danger"></i>
                </td>
                <td class="no-borders">
                    <strong> {{_i('Created at')}} </strong> : {{$article->created_at->format('m-d-Y')}}
                </td>
                <td class="no-borders">
                    <strong> {{_i('Client')}} </strong> : {{$article->project->client->name}}
                </td>
                <td class="no-borders">
                    <strong>  {{_i('Title')}} </strong> : {{$article->title}}
                </td>
                <td class="no-borders">
                    <strong> {{_i('Author')}} </strong> : {{$article->author->name}}
                </td>
                <td class="no-borders">
                    <strong> {{_i('Disapprovals')}} </strong> : {{$article->attempts}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="p-sm text-muted">
        {{_i('No results')}}
    </div>
@endif