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

    {{--TODO show content depens on state--}}
@endsection