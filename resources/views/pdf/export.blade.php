<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<center>
    <h1>Project: {{$project->name}}</h1>
</center>
<h4>Client: {{$project->client->name}}</h4>
<h4>Plan: {{$project->plan->name}}</h4>
<p>
    Link: <a href="{{action('ProjectController@show', $project)}}">Click</a>
</p>

<center>
    <h2>Plan requirments</h2>
</center>
<table class="table table-bordered">
    @foreach($project->plan_metadata as $key => $value)
        <tr>
            <td>
                {{ucwords( str_replace('_',' ',$key) )}}:
            </td>
            <td>
                @if($project->isModified($key))
                    {{ (is_bool($project->getModified($key)))
                    ? ($project->getModified($key)) ?_i('Yes') : _i('No') : $project->getModified($key)  }}
                @else
                    {{ (is_bool($value)) ? ($value) ?_i('Yes') : _i('No') : $value  }}
                @endif
            </td>
        </tr>
    @endforeach
</table>
<div class="page-break"></div>

<center>
    <h2>Quiz result</h2>
</center>
@foreach($meta as $key => $value)
    <div>
        @if(is_array($value))
            <b>{{$key}} : </b> <br>
            @foreach($value as $subkey => $subvalue)
                @if($subvalue)
                    <span style="text-indent:25px;">
                        - {!!  (is_int($subkey)) ? $subvalue : $subkey . ' : ' . $subvalue !!}
                    </span> <br>
                @endif
            @endforeach
        @else
            @if($value)
                <b> {{$key}} : </b> {{$value}}
            @endif
        @endif
    </div>
    <br>
@endforeach
<div class="page-break"></div>

<center>
    <h2>Keywords</h2>
</center>

@if(is_array($project->keywords))
    @foreach($project->keywords as $theme => $keywords)
        @if(empty($keywords))
            @continue
        @endif
        <div>
            <b>{{$theme}} : </b> <br>
            {{implode(', ', array_keys($keywords))}}
        </div>
        <br>
    @endforeach
@endif
<div class="page-break"></div>

<center>
    <h2>Keywords Questions</h2>
</center>
@if(is_array($project->keywords_questions))
    @foreach($project->keywords_questions as $theme => $keywords)
        @if(empty($keywords))
            @continue
        @endif
        <div>
            <b>{{$theme}} : </b> <br>
            {{implode(', ', array_keys($keywords))}}
        </div>
        <br>
    @endforeach
@endif
<div class="page-break"></div>

<center>
    <h2>Keywords Additional Info</h2>
</center>
@if(is_array($project->keywords_meta))
    @foreach($project->keywords_meta as $theme => $data)
        @if(empty($data))
            @continue
        @endif
        <div>
            <b>{{$theme}} : </b> <br>
            @foreach($data as $key => $value)
                @if(!$value)
                    @continue
                @endif
                <span style="text-indent:25px;"> - {{$key}} : {{$value}}</span> <br>
            @endforeach
        </div>
        <br>
    @endforeach
@endif
<div class="page-break"></div>


</body>
</html>