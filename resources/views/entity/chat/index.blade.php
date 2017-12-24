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
    <div class="tabs-container">
        <div class="tabs-left">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <ul class="nav nav-tabs">
                    @foreach($conversations as $conversation)
                        <li class="{{($loop->first)?'active':''}}">
                            <a class="message-switcher"
                               data-sourse="{{action('MessageController@show', $conversation->id)}}"
                               href="#">{{$conversation->data['title']}}</a>
                        </li>
                        <li>
                            <a class="message-switcher"
                               data-sourse="{{action('MessageController@show', $conversation->id)}}"
                               href="#">{{$conversation->data['title']}}</a>
                        </li>
                        <li>
                            <a class="message-switcher"
                               data-sourse="{{action('MessageController@show', $conversation->id)}}"
                               href="#">{{$conversation->data['title']}}</a>
                        </li>
                        <li>
                            <a class="message-switcher"
                               data-sourse="{{action('MessageController@show', $conversation->id)}}"
                               href="#">{{$conversation->data['title']}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div id="messages-container" class="col-xs-11 col-sm-11 col-md-11 col-lg-11"></div>
        </div>
    </div>

@endsection

@section('scripts')
    <style>
        .role-placeholder {
            border-radius: 50%;
            width: 1.5em;
            height: 1.5em;
            padding: 8px;
            background: #fff;
            border: 2px solid white;
            color: white;
            text-align: center;
            font: 3em Arial, sans-serif;
            line-height: 1em;
            margin: 0;
        }
    </style>
    <script>
        $(".message-switcher").click(function () {
            $("#messages-container").load($(this).attr('data-sourse'));
        });
    </script>
@endsection


