<div class="">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#plan-wrapper" data-toggle="tab">Plan</a>
        </li>
        <li class="">
            <a href="#quiz-wrapper" data-toggle="tab">Quiz</a>
        </li>
        <li class="">
            <a href="#keywords-wrapper" data-toggle="tab">Keywords</a>
        </li>
    </ul>
    <div class="tab-content clearfix">
        <div class="tab tab-pane" id="plan-wrapper">
            @include('pages.client.projects.tabs.plan')
        </div>
        <div class="tab tab-pane active" id="quiz-wrapper">
            @include('pages.client.projects.tabs.quiz')
        </div>
        <div class="tab tab-pane" id="keywords-wrapper">
            @include('pages.client.projects.tabs.keywords')
        </div>
    </div>
</div>



