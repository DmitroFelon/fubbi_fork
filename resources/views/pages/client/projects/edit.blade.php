@extends('master')

@section('content')
    @includeIf('pages.client.projects.states.'.$project->state)
@endsection