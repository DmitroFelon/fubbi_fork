@extends('master')

@section('content')

    <div><h2>{{$project->subscription->name}}</h2></div>
    <div class="text-muted">{{$project->subscription->created_at}}</div>
    <div>{{$project->subscription->stripe_plan}}</div>

    @include('pages.client.projects.form')


@endsection

