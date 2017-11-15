@extends('master')

@section('content')
    {!! Form::open(['method' => 'POST', 'role'=>'form', 'id' => 'project-form', 'action' => ['ProjectController@store']]) !!}

    @include('pages.client.projects.form')
    <div class='form-group'>
        {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
    </div>
    {!! Form::close() !!}

@endsection


