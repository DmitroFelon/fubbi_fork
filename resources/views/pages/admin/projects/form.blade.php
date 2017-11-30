@include('partials.errors')

@switch($step)
@case(\App\Models\Project::PLAN_SELECTION)
@include('pages.client.projects.tabs.plan')
@break
@case(\App\Models\Project::QUIZ_FILLING)
@include('pages.client.projects.tabs.quiz')
@break
@case(\App\Models\Project::KEYWORDS_FILLING)
@include('pages.client.projects.tabs.keywords')
@break
@case(\App\Models\Project::MANAGER_REVIEW)
   <div class="text-primary">
       {{__('Project is on manager review.')}}
   </div>
@break
@case(\App\Models\Project::PROCESSING)
<div class="text-primary">
    {{__('We are working on your project')}}
</div>
<div class="text-primary">
    <a href="#">{{__('See results')}}</a>
</div>
@break
@default
error
@endswitch

