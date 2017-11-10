<div class="form-group">
    {!! Form::hidden('themes-order', null, ['id'=>'themes-order']) !!}
    {!! Form::label('themes', 'Content themes') !!}
    {!! Form::text('themes', null, ['id' => 'themes-input','class' => 'form-control', 'data-role' => 'tagsinput']) !!}
    <div class="text-muted">
        Type at least 10 themes
    </div>
    <br>
    {!! Form::label('', 'Order by priority') !!}
    <ul id="themes-order-list" class="list-group sortable">
    </ul>

</div>
