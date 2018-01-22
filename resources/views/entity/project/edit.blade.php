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
                                {{_i('Make a research before filling quiz')}}
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

@section('before-scripts')
    @if($project->step == \App\Models\Helpers\ProjectStates::PLAN_SELECTION)
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    @endif
@endsection