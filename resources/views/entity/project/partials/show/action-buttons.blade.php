@role(['account_manager', 'admin'])
<a href="{{url()->action('ProjectController@edit', $project)}}" class="btn btn-white btn-xs pull-right">
    {{__('Edit project')}}
</a>

<a href="{{url("project/accept_review/{$project->id}")}}" class="btn btn-primary btn-xs pull-right">
    {{__('Accept review')}}
</a>

<a href="{{url("project/reject_review/{$project->id}")}}" class="btn btn-danger btn-xs pull-right">
    {{__('Reject review')}}
</a>
@endrole()
@role(['client'])
<a href="{{url()->action('ProjectController@edit', $project)}}" class="btn btn-white btn-xs pull-right">
    {{__('Edit project')}}
</a>
@endrole()