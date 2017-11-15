@extends('master')

@section('content')
    {!! Form::model($project, ['method' => 'PUT', 'role'=>'form', 'id' => 'project-form', 'action' => ['ProjectController@update', 'id' => $project->id]]) !!}
    @include('pages.client.projects.form')
    {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
    {!! Form::close() !!}
@endsection

@section('script')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
@endsection
