@extends('master')

@section('content')
    @foreach($users as $user)
        <a target="_blank" href="user/{{$user->id}}">{{$user->name}}</a> <br>
    @endforeach
@endsection