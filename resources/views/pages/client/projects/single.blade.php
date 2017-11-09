@extends('master')

@section('content')

    @includeIf('pages.client.projects.states.'.$project->state)
    {{--TODO show content depens on state--}}
@endsection