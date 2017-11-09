<div class="project-card col-xs-3 col-sm-3 col-md-3 col-lg-3">
    <div>
        <div class="project-name">
            <a href="{{url('/projects/single/'.$project->id)}}">{{$project->name}}</a>
        </div>
        <div class="project-name">
            <span>{{$project->state}}</span>
        </div>
        <div class="project-workers">
            @foreach($project->workers as $worker)
                @include('partials.client.projects.worker')
            @endforeach
        </div>
    </div>
</div>