<fieldset>
    <br>
    {!! Form::hidden('themes_order', null, ['id'=>'themes_order', 'required']) !!}
    {!! Form::bsText('themes', null, 'Type content themes here', 'Type at least 10 themes. Separate by coma or click "enter".', ['required', 'data-role'=>"tagsinput"]) !!}
    <div class="form-group @if( isset($project) and $project->themes_order != '' ) hide @endif" id="themes-order-list-wrapper">
        {!! Form::label('', 'Please list top 5 content themes in order of priority.') !!}
        <div class="text-muted">Drag and drop</div>
        {{$project->getMeta('themes_order')}}
        <ul id="themes-order-list" class="list-group sortable">
            @if( isset($project) and $project->themes_order != '' )
                @foreach(explode(',',$project->themes_order) as $row)
                    <li class="list-group-item" data-value="{{$row}}">{{$row}}</li>
                @endforeach
            @endif
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

</fieldset>