@extends('master')

@section('content')
    <div class="ibox-content">
    <blockquote>
        <div>
            <a class="lead" target="_blank" href="{{url()->action('ProjectController@show', $project)}}">
                {{title_case($project->subscription->name)}}
            </a>
            <span class="text-muted">
               <small>

                   {{__('Create at')}}: {{$project->subscription->created_at}}
               </small>
            </span>
            <span class="text-muted">
                <small>
                    {{__('Selected plan')}}: {{title_case(str_replace('-',' ',$project->subscription->stripe_plan))}}</small>
            </span>

        </div>
    </blockquote>

    @include('entity.project.form')
    </div>
@endsection

