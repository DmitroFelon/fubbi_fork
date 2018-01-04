<div class="ibox-title">
    <h5>Select Keywords</h5>
</div>
<div class="ibox-content">
    {!! Form::model($project,
    ['files' => true, 'method' => 'POST', 'role'=>'form', 'id' => 'keywords-form', 'action' => ['ProjectController@update', $project->id]])
    !!}
    {!! Form::hidden('_step', \App\Models\Helpers\ProjectStates::KEYWORDS_FILLING) !!}
    {!! Form::hidden('_project_id', $project->id)  !!}

    {{--Themes' keywords tabs--}}
    @foreach(collect(explode(',', $project->themes)) as $theme)
        <h1>{{$theme}}</h1>
        <fieldset data-theme="{{$theme}}" data-mode="async" data-url="{{url()->action('KeywordsController@index', [$project->id, $theme])}}">

        </fieldset>
    @endforeach

    {{--Questions' keywords tabs--}}
    @foreach(collect(explode(',', $project->questions)) as $question)
        <h1>{{$question}}</h1>
        <fieldset data-theme="{{$question}}"  data-mode="async" data-url="{{url()->action('KeywordsController@index', [$project->id, $question])}}">

        </fieldset>
    @endforeach

    {!! Form::close() !!}

</div>
