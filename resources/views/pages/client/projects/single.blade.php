@extends('master')

@section('content')
    {{$project->name}}
    <br>
    {{$project->description}}
    <br>
    Workers: {{count($project->workers)}}
    <br>
    Status:
    {{$project->state}}
@endsection