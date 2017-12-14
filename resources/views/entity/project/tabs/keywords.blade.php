{!! Form::model($project,
['files' => true, 'method' => 'PUT', 'role'=>'form', 'id' => 'keywords-form', 'action' => ['ProjectController@update', $project->id]])
!!}
{!! Form::hidden('_step', \App\Models\Helpers\ProjectStates::KEYWORDS_FILLING) !!}
{!! Form::hidden('_project_id', $project->id)  !!}

@foreach(collect(explode(',', $project->themes)) as $theme)
    <h1>{{$theme}}</h1>
    <fieldset data-mode="async" data-url="{{url()->action('KeywordsController@index', [$project->id, $theme])}}">

    </fieldset>
@endforeach

{!! Form::close() !!}
