
@role(['admin', 'account_manager'])
    @include('entity.project.tabs.quiz')
    @include('entity.project.tabs.keywords')
@endrole


@role(['client'])
    @switch($step)
    @case(\App\Models\Helpers\ProjectStates::PLAN_SELECTION)
        @include('entity.project.tabs.plan')
        @break
    @case(\App\Models\Helpers\ProjectStates::QUIZ_FILLING)
        @include('entity.project.tabs.quiz')
        @break
    @case(\App\Models\Helpers\ProjectStates::KEYWORDS_FILLING)
        @include('entity.project.tabs.keywords')
        @break
    @case(\App\Models\Helpers\ProjectStates::MANAGER_REVIEW)
        <div class="text-primary">
            {{_i('Project is on manager review.')}}
        </div>
        @break
    @case(\App\Models\Helpers\ProjectStates::PROCESSING)
        <div class="text-primary">
            {{_i('We are working on your project')}}
        </div>
        <div class="text-primary">
            <a href="#">{{_i('See results')}}</a>
        </div>
        @break
    @default
        impossible state
    @endswitch
@endrole



