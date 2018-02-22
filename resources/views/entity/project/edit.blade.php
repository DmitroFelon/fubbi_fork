@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4 p-md">
            <div class="row">


                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

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
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    @foreach(\App\Models\Helpers\Page::getRelatedVideos() as $video)
                        test
                        <iframe id="=" type="text/html" width="450"
                                src="{{$video->player}}"
                                frameborder="0"></iframe>
                    @endforeach

                </div>
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
