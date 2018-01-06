@role(['account_manager', 'admin'])
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
   class="btn btn-danger btn-xs btn-xs m-r-sm p-w-sm">
    {{_i('Modify Plan')}}
</a>
@endrole
@role(['client'])
<a href="{{url()->action('ProjectController@edit', $project)}}"
   class="btn btn-primary btn-xs btn-xs m-r-sm p-w-sm">
    {{_i('Edit project')}}
</a>
@endrole
<a href="{{url()->action('Project\ArticlesController@create', $project)}}"
   class="btn btn-success btn-xs btn-xs m-r-sm p-w-sm">
    {{_i('Add article')}}
</a>
<a class="collapse-link">
    <i class="fa fa-chevron-up"></i>
</a>