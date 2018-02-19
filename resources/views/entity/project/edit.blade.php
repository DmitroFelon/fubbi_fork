@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4 p-md">
            <div>
                <a class="lead" target="_blank" href="{{url()->action('Resources\ProjectController@show', $project)}}">
                    {{title_case($project->name)}}
                </a><br>
                <small class="text-muted">
                    {{_i('Created')}}: {{$project->subscription->created_at->diffForHumans()}}
                    <small>
                        ({{$project->subscription->created_at}})
                    </small>
                </small>
                <br>
                <small class="text-muted">
                    {{_i('Selected plan')}}
                    : {{ title_case(str_replace('-',' ',$project->subscription->stripe_plan))}}
                </small>

                @role([\App\Models\Role::CLIENT])
                <div class="m-t-md">
                            <span class="text-primary">
                                <a target="_blank" href="{{action('ResearchController@index')}}">
                                    {{_i('Click here to conduct research before filling out quiz')}}
                                </a>
                            </span>
                </div>
                @endrole
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="ibox">
        @include('entity.project.form')
    </div>
@endsection


@section('scripts')

@endsection
