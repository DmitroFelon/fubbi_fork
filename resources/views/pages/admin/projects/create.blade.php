@extends('master')

@section('content')
    {!! Form::model($project, ['method' => 'POST', 'action' => ['ProjectController@store']]) !!}
    @include('candidates.form', ['submitButtonText' => 'Edit Candidate'])
    {!! Form::close() !!}
@endsection

@section('script')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
@endsection
