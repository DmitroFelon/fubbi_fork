<div class="ibox-title">
    <h5>Select Keywords</h5>
</div>
<div class="ibox-content">
    {!! Form::model($project,
    ['files' => true, 'method' => 'PUT', 'role'=>'form', 'id' => 'keywords-form', 'action' => ['ProjectController@update', $project->id]])
    !!}
    {!! Form::hidden('_step', \App\Models\Helpers\ProjectStates::KEYWORDS_FILLING) !!}
    {!! Form::hidden('_project_id', $project->id)  !!}

    {{--Themes' keywords tabs--}}
    @foreach($project->prepareTagsInput('themes_order') as $theme)
        @if(!trim($theme))
            @continue
        @endif
        <h1>{{$theme}}</h1>
        <fieldset data-theme="{{$theme}}" data-mode="async"
                  data-url="{{url()->action('KeywordsController@index', [$project->id, $theme])}}">
            {{--loaded by ajax--}}
        </fieldset>
    @endforeach
    {{--Questions' keywords tabs--}}
    @foreach($project->prepareTagsInput('questions') as $question)
        @if(!trim($question))
            @continue
        @endif
        <h1>{{$question}}</h1>
        <fieldset data-theme="{{$question}}" data-mode="async"
                  data-url="{{url()->action('KeywordsController@index', [$project->id, $question])}}">
            {{--loaded by ajax--}}
        </fieldset>
    @endforeach
    {!! Form::close() !!}
</div>
