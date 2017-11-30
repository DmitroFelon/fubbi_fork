@extends('master')

@section('content')

    <blockquote>
        <div>
            <a class="lead" target="_blank" href="{{url()->action('ProjectController@show', $project)}}">
                {{title_case($project->subscription->name)}}
            </a>
            <span class="text-muted">
               <small>

                   Create at: {{$project->subscription->created_at}}
               </small>
            </span>
            <span class="text-muted">
                <small>
                    Selected plan: {{title_case(str_replace('-',' ',$project->subscription->stripe_plan))}}</small>
            </span>

        </div>
    </blockquote>

    @include('pages.client.projects.form')

@endsection

