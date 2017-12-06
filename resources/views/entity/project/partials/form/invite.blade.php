<div class="row wrapper border-bottom blue-bg page-heading">
    <div class="col-sm-12">
        <h3 class="text-center p-xs">
            {{__('This project requires a %s', implode(', ',$project->requireWorkers())) }}
        </h3>
    </div>
    <div class="col-sm-6 text-center">
        <a href="{{url("project/apply_to_project/{$project->id}")}}" class="btn btn-lg btn-primary">{{__('Accept')}}</a>
    </div>
    <div class="col-sm-6 text-center">
        <a href="{{url("project/decline_project/{$project->id}")}}" class="btn btn-lg btn-danger">{{__('Decline')}}</a>
    </div>
</div>