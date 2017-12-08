{{--
<ul class="nav nav-tabs">
    @for($i=1;$i<9;$i++)
        <li class="{{($i==1)?'active':''}}">
            <a href="#keyword-{{$i}}" data-toggle="tab">Overview {{$i}}</a>
        </li>
    @endfor
</ul>
{!! Form::model($project,
['files' => true, 'method' => 'PUT', 'role'=>'form', 'id' => 'project-form', 'action' => ['ProjectController@update', $project->id]])
!!}
{!! Form::hidden('_step', \App\Models\Project::KEYWORDS_FILLING) !!}

<div class="tab-content clearfix">
    @for($i=1;$i<9;$i++)
        <div class="tab tab-pane {{($i==1)?'active':''}}" id="keyword-{{$i}}">
            @foreach(array_chunk($keywords, 10)[$i] as $keyword)
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <label>
                        <input @if($project->keywords->find($keyword["id"]) != null) checked="checked" @endif name="keywords[]" type="checkbox" value="{{$keyword["id"]}}">
                        {{ucfirst($keyword["text"])}}
                    </label>
                </div>
            @endforeach
        </div>
    @endfor
</div>
{!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
{!! Form::close() !!}
--}}

{!! Form::model($project,
['files' => true, 'method' => 'PUT', 'role'=>'form', 'id' => 'keywords-form', 'action' => ['ProjectController@update', $project->id]])
!!}
{!! Form::hidden('_step', \App\Models\Helpers\ProjectStates::KEYWORDS_FILLING) !!}

@for($i=1;$i<9;$i++)
    <h1>Overview {{$i}}</h1>
    <fieldset>
        @foreach(array_chunk($keywords, 10)[$i] as $keyword)
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <label>
                    <input @if($project->keywords->find($keyword["id"]) != null) checked="checked" @endif name="keywords[]" type="checkbox" value="{{$keyword["id"]}}">
                    {{ucfirst($keyword["text"])}}
                </label>
            </div>
        @endforeach
    </fieldset>
@endfor


{!! Form::close() !!}
