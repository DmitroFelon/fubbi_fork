<fieldset>
{!! Form::hidden('themes-order', null, ['id'=>'themes-order']) !!}
{!! Form::bsText('themes', null, 'Type content themes here', 'Type at least 10 themes', ['data-role'=>"tagsinput"]) !!}
<div class="form-group">
    {!! Form::label('', 'Please list top 5 content themes in order of priority.') !!}
    <ul id="themes-order-list" class="list-group sortable">
    </ul>
</div>
{!! Form::bsText('questions', null, 'What are the top 3 questions clients desperately want answers to?', null, ['data-role'=>"tagsinput"]) !!}
{!! Form::bsText('relevance', null, 'Is it essential that the content we create for you be relevant to a specific country, state or city? Please explain', null, []) !!}
{!! Form::bsText('audience', null, 'Who is your ideal target audience? Describe their 1. age, 2. sex, 3. income 4. education 5.profession', null, []) !!}
{!! Form::bsText('homepage', null, 'What is the home page url of the website we are creating content for?', null, ['required']) !!}
</fieldset>