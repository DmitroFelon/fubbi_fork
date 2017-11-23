@extends('master')

@section('content')
    {{$project->name}}

    <br>

    {{$project->getMeta()}}

    @foreach(\App\Models\Project::$media_collections as $collection)
        @foreach($project->getMedia($collection) as $media)
            <img src="{{$media->getFullUrl()}}">
        @endforeach
    @endforeach

@endsection