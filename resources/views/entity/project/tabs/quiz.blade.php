
<div class="ibox-title">
    <h5>Fill quiz</h5>
</div>

<div class="ibox-content">

    {!! Form::model($project,
    ['files' => true, 'method' => 'PUT', 'role'=>'form', 'id' => 'quiz-form', 'action' => ['ProjectController@update', $project->id]])
    !!}
    {!! Form::hidden('_step', \App\Models\Helpers\ProjectStates::QUIZ_FILLING) !!}
    {!! Form::hidden('_project_id', $project->id ) !!}
    {!! Form::hidden('themes_order', null, ['id'=>'themes_order']) !!}
    <h1>Step 1</h1>
    <fieldset>
        {!! Form::bsText(
            'themes', null,
            _i("Type content themes here"),
            _i("Type at least 10 themes. Separate by coma or click 'enter'."),
            ['required', 'class'=> 'tagsinput' ]
        ) !!}
        <div class="form-group @unless( isset($project) and $project->themes_order != '' ) hide @endunless"
             id="themes-order-list-wrapper">
            {!! Form::label('', _i("Please reorder themes in order of priority.")) !!}
            <div class="text-muted">Drag and drop</div>
            <ul id="themes-order-list" class="list-group sortable">
                @isset($project)
                @foreach(explode(',',$project->themes_order) as $row)
                    @if($row != '')
                        <li class="list-group-item" data-value="{{$row}}">{{$row}}</li>
                    @endif
                @endforeach
                @endisset
            </ul>
        </div>
        {!! Form::bsText(
            'questions', null,
            _i('What are the top 3 questions clients desperately want answers to?'),
            _i("Separate by coma or click 'enter'"),
            ['required', 'class'=> 'tagsinput' ]
        ) !!}
    </fieldset>
    <h1>Step 2</h1>
    <fieldset>
        {!! Form::bsText('relevance', null, _i('Is it essential that the content we create for you be relevant to a specific country, state or city? Please explain'), '', ['required']) !!}
        <div class="row">
            <h4 class="text-center"><strong>Who is your ideal target audience?</strong></h4>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                {!! Form::bsText('audience[age]', null, _i('Age'), null, [], 'number') !!}
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                {!! Form::bsText('audience[sex]', null, _i('Sex'), null, []) !!}
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                {!! Form::bsText('audience[Income]', null, _i('Income'), null, []) !!}
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                {!! Form::bsText('audience[education]', null, _i('Education'), null, []) !!}
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                {!! Form::bsText('audience[profession]', null, _i('Profession'), null, []) !!}
            </div>
        </div>
        {!! Form::bsText('homepage', null, _i('What is the home page url of the website we are creating content for?'), '', ['required'], 'url') !!}


    </fieldset>
    <h1>Step 3</h1>
    <fieldset>
        {!! Form::bsSelect('language', ['en-us' => 'English - United States', 'en-gb' => 'English - Great Britain', 'en-au' => 'English - Australia'], null, _i('What language do you want us to write content in?'), '', ['required']) !!}
        <h4 class="text-center"><strong>{{_i("Here are our three writing styles. Please review each one of them and then select
            one.")}}</strong></h4>
        <ol>
            <li>
                <strong>{{_i("Fact based")}}:</strong>
                <a target="_blank"
                   href="https://drive.google.com/open?id=1FcI8StKK3ykMggGZsQBzAw0gPdutfYC0pY1hTluxL1M">{{_i("Click Here")}}</a>
            </li>
            <li>
                <strong>{{_i("Emotional")}}:</strong>
                <a target="_blank"
                   href="https://docs.google.com/document/d/1p8cmQaUfzK0tZfGWsmgLllcHDXlJs6TAFTqTr148iFk/edit">{{_i("Click Here")}}</a>
            </li>
            <li>
                <strong>{{_i("Middle Road")}}:</strong>
                <a target="_blank
            "
                   href="https://docs.google.com/document/d/1NrZsKQHzt9_82nwxS9twRn3P1EdYNnaHlAvEc-0rW2Y/edit">{{_i("Click Here")}}</a>
            </li>
        </ol>
        {!! Form::bsSelect('writing_style', config('fubbi.form.quiz.writing_style'),
         null, _i("Please select from the drop-down menu the style you prefer"), '', ['required']) !!}
        {!! Form::bsSelect('graphic_styles', config('fubbi.form.quiz.graphic_style'), null, _i("Please select from the drop-down menu the style you prefer"), '', ['required']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading collapsible" data-toggle="collapse" href="#quora-block">
                            <h4 class="panel-title">
                                <span>{{_i("For some of our packages we publish on Quora. Do you have a Quora account? (it’s a secure field)")}}</span>
                                <i class="text-right fa fa-expand right" aria-hidden="true"></i>
                            </h4>
                        </div>
                        <div id="quora-block" class="panel-collapse row collapse">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    {!! Form::bsText('quora_username', null, _i("Username"), null, ['autocomplete' => 'off']) !!}
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    {!! Form::bsText('quora_password', null, _i("Password"), null, ['autocomplete' => 'new-password'], 'password') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading collapsible" data-toggle="collapse" href="#seo-block">
                            <h4 class="panel-title">
                                <span>{{_i("Do you have an SEO Company?")}}</span>
                                <i class="text-right fa fa-expand right" aria-hidden="true"></i>
                            </h4>
                        </div>
                        <div id="seo-block" class="panel-collapse row collapse">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    {!! Form::bsText('seo_first_name', null, _i("SEO Contact Name"), _i("First Name"), [], '') !!}
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    {!! Form::bsText('seo_last_name', null, ' ', _i("Last Name"), []) !!}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    {!! Form::bsText('seo_email', null, _i("SEO Contact Email"), null, [], 'email') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </fieldset>
    <h1>Step 4</h1>
    <fieldset>
        {!! Form::bsText('example_article', null, _i("Please copy the URL of one article the exhibits a writing style that would like for your content"), null, [], 'url') !!}
        {!! Form::bsText('compliance_guideline', null, _i("Do you have branding guidelines?"), '', ['multiple'], 'file') !!}
        {!! Form::bsText('logo', null, _i("Do you have a high resolution logo that we can use?"), '', [], 'file') !!}
        {!! Form::bsText('article_images[]', null, _i("Do you want us to add images to your articles?"), _i("Not all clients do as it’s somewhat subjective. If yes, please help us prepare the perfect images for your content. If you have photos you want to upload, you can do that too. Please understand that images can be “very” expensive but we’ll do the best we can for you. Please upload at least 5 image samples."), ['multiple'], 'file') !!}
        {!! Form::bsText('article_images_links', null, _i("You can do that by sharing examples to 5 articles with images that you like – just type in the URL."), _i('Separate by coma or click "enter".'), ['required', 'class'=>'tagsinput' ] ) !!}
        {!! Form::bsText('avoid_keywords', null, _i('Do you have keywords that you want us to avoid or content that you would not want us to use? Separate by coma or click "enter".'), '', [ 'class'=>'tagsinput']) !!}
        {!! Form::bsText('image_pages', null, _i("You can also send us URLs of web pages that have the kind of images you like. Just type the urls below."), '', [ 'class'=>'tagsinput']) !!}
    </fieldset>
    <h1>Step 5</h1>
    <fieldset>
        {!! Form::bsText('google_access', null, _i("We use Google docs to have you approve your articles. Please add all the email addresses of people in your organisation that need access."), '', [ 'class'=>"tagsinput"]) !!}
        {!! Form::bsText('cta', null, _i("Do you want us to add calls to action (CTA) to the end of your articles?"), _i("Examples include phoning your office for a complimentary consultation or review. Other times it might be to option in to receive a free report. If you want us to close your articles with a CTA please provide us with specific information i.e. if you want them to download a free report, please share a link to the download offer. If you want people to phone your office please provide details of what you’ll share on the phone call. We will, in turn create a one paragraph call to action for your articles"), ['rows' => '3'],'textarea') !!}
        {!! Form::bsText('ready_content', null, _i("Do you already have content you've produced that you wish to see in future articles? If so, please upload transcripts."), _i("Note: You do not have to upload all your content now. Just enough to get us started with producing your articles and social posts. You can send us more at a later date. Please upload up to 10 transcripts"), ['multiple'], 'file') !!}
        {!! Form::bsSelect('articles_preview', ['yes' => 'Yes', 'no' => 'No'], 'yes', _i("Do you want to review outlines before we send you articles to approve?"), _i("Note: Most clients say 'no'. You however should say 'yes' if 1. you've worked with writers before and you've never been happy, or... 2. If you know you're very selective , or... 3. Your audience has 'very' acute knowledge about a subject that is highly specialised"), []) !!}
    </fieldset>
    {!! Form::close() !!}
</div>


