<a href="{{action('ProjectController@export', $project)}}" class="btn btn-white yellow-bg btn-xs btn-xs m-r-sm p-w-sm">
    <i class="fa fa-download"></i> {{_i('Export')}}
</a>

@can('project.accept-review', $project)

    @if($project->isOnReview())
        <a href="{{url("project/accept_review/{$project->id}")}}"
           class="btn btn-primary btn-xs btn-xs m-r-sm p-w-sm">
            {{_i('Accept review')}}
        </a>
        <a href="{{url("project/reject_review/{$project->id}")}}"
           class="btn btn-danger btn-xs btn-xs m-r-sm p-w-sm">
            {{_i('Reject review')}}
        </a>
    @endif()

    <a href="{{url()->action('Project\PlanController@edit', [$project, $project->plan->id])}}"
       class="btn btn-warning btn-xs btn-xs m-r-sm p-w-sm">
        {{_i('Modify Plan')}}
    </a>
@endcan

@role([\App\Models\Role::ADMIN, \App\Models\Role::ACCOUNT_MANAGER, \App\Models\Role::CLIENT])
    @can('project.update', $project)
        <a href="{{url()->action('ProjectController@edit', $project)}}"
           class="btn btn-primary btn-xs btn-xs m-r-sm p-w-sm">
            {{_i('Edit project')}}
        </a>
    @endcan
@endrole

<a href="{{url()->action('Project\ArticlesController@create', $project)}}"
   class="btn btn-success btn-xs btn-xs m-r-sm p-w-sm">
    {{_i('Add article')}}
</a>
<a class="collapse-link">
    <i class="fa fa-chevron-up"></i>
</a>