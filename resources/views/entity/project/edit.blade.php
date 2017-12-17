@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4 p-md">
            <div>
                <a class="lead" target="_blank" href="{{url()->action('ProjectController@show', $project)}}">
                    {{title_case($project->subscription->name)}}
                </a><br>
                <small class="text-muted">
                    {{_i('Created')}}: {{$project->subscription->created_at->diffForHumans()}}
                    <small>
                        ({{$project->subscription->created_at}})
                    </small>
                </small><br>
                <small class="text-muted">
                    {{_i('Selected plan')}}
                    : {{title_case(str_replace('-',' ',$project->subscription->stripe_plan))}}
                </small>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="ibox">
        @include('entity.project.form')
    </div>

@endsection

