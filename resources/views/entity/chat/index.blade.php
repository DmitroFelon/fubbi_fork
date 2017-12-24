@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>
                {{_i('Chat')}}
            </h2>
        </div>
    </div>
@endsection

@section('content')

    @foreach($conversations as $conversation)

        <div>
            <a href="{{action('MessageController@show', $conversation->id)}}">conv</a>
        </div>

    @endforeach

@endsection


