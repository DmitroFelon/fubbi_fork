@extends('master')

@section('content')
    @foreach($projects as $project)
        @include('partials.client.projects.card')
    @endforeach
    <div class="project-add col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div align="center" class="transparent">
            <i onclick="window.location.replace('{{route('projects.create')}}');" class="fa fa-plus fa-4x"></i>
        </div>
    </div>
@endsection
