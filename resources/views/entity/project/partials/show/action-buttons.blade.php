@role(['account_manager', 'admin'])
@if($project->isOnReview())
    <a href="{{url("project/accept_review/{$project->id}")}}" class="btn btn-primary btn-xs pull-right">
        {{_i('Accept review')}}
    </a>

    <a href="{{url("project/reject_review/{$project->id}")}}" class="btn btn-danger btn-xs pull-right">
        {{_i('Reject review')}}
    </a>

@endif()

<a href="{{url()->action('Project\PlanController@edit', [$project, $project->plan->id])}}" class="btn btn-danger btn-xs pull-right">
    {{_i('Modify Plan')}}
</a>
@endrole()
@role(['client'])
<a href="{{url()->action('ProjectController@edit', $project)}}" class="btn btn-white btn-xs pull-right">
    {{_i('Edit project')}}
</a>
@endrole()