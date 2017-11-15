<fieldset>
    <br>
    {!! Form::hidden('themes_order', null, ['id'=>'themes_order']) !!}
    {!! Form::bsText('themes', null, 'Type content themes here', 'Type at least 10 themes. Separate by coma or click "enter".', [ 'data-role'=>"tagsinput"]) !!}

    <div class="form-group @unless( isset($project) and $project->themes_order != '' ) hide @endunless"
         id="themes-order-list-wrapper">
        {!! Form::label('', 'Please list top 5 content themes in order of priority.') !!}
        <div class="text-muted">Drag and drop</div>
        <ul id="themes-order-list" class="list-group sortable">
            @foreach(explode(',',$project->themes_order) as $row)
                @if($row != '')
                    <li class="list-group-item" data-value="{{$row}}">{{$row}}</li>
                @endif
            @endforeach
        </ul>
    </div>

    {!! Form::bsText('questions', null, 'What are the top 3 questions clients desperately want answers to? ', 'Separate by coma or click "enter".', ['required', 'data-role'=>"tagsinput"]) !!}
    {!! Form::bsText('relevance', null, 'Is it essential that the content we create for you be relevant to a specific country, state or city? Please explain', null, ['required']) !!}
    <div class="row">
        <h4 class="text-center">Who is your ideal target audience?</h4>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! Form::bsText('audience[age]', null, 'Age', null, []) !!}
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! Form::bsText('audience[sex]', null, 'Sex', null, []) !!}
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! Form::bsText('audience[Income]', null, 'Income', null, []) !!}
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! Form::bsText('audience[education]', null, 'Education', null, []) !!}
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! Form::bsText('audience[profession]', null, 'Profession', null, []) !!}
        </div>
    </div>
    {!! Form::bsText('homepage', null, 'What is the home page url of the website we are creating content for?', null, ['required']) !!}
    {!! Form::bsSelect('language', ['en-us' => 'English - United States', 'en-gb' => 'English - Great Britain', 'en-au' => 'English - Australia'], null, 'What language do you want us to write content in?', '', ['required']) !!}
    <h4 class="text-center">Here are our three writing styles. Please review each one of them and then select one.</h4>
    <ol>
        <li>
            <strong>Fact based:</strong>
            <a target="_blank" href="https://drive.google.com/open?id=1FcI8StKK3ykMggGZsQBzAw0gPdutfYC0pY1hTluxL1M">Click
                Here</a>
        </li>
        <li>
            <strong>Emotional:</strong>
            <a target="_blank"
               href="https://docs.google.com/document/d/1p8cmQaUfzK0tZfGWsmgLllcHDXlJs6TAFTqTr148iFk/edit">Click
                Here</a>
        </li>
        <li>
            <strong>Middle Road:</strong>
            <a target="_blank
            " href="https://docs.google.com/document/d/1NrZsKQHzt9_82nwxS9twRn3P1EdYNnaHlAvEc-0rW2Y/edit">Click Here</a>
        </li>
    </ol>
    {!! Form::bsSelect('writing_style', config('fubbi.form.quiz.writing_style'),
     null, 'Please select from the dropdown menu the style you prefer', '', ['required']) !!}
    {!! Form::bsSelect('graphic_styles', config('fubbi.form.quiz.graphic_style'), null, 'Please select from the dropdown menu the style you prefer', '', ['required']) !!}

</fieldset>