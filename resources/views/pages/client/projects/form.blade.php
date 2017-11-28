@include('partials.errors')

@switch($step)
@case('plan')
@include('pages.client.projects.tabs.plan')
@break
@case('quiz')
@include('pages.client.projects.tabs.quiz')
@break
@case('keywords')
@include('pages.client.projects.tabs.keywords')
@break
@default
error
@endswitch

