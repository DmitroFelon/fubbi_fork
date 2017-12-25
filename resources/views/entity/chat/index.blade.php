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
                        <li class="{{($loop->first)?'active first-chat ':''}}">
                            <a data-conversation-id="{{$conversation->id}}" class="message-switcher"
                               data-sourse="{{action('MessageController@show', $conversation->id)}}"
                               href="#">{{$conversation->data['title']}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            {{--
            Chat loaded by ajax from view: "entity.chat.show"
            --}}
            <div id="messages-container" class="col-xs-11 col-sm-11 col-md-11 col-lg-11"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        .role-placeholder {
            border-radius: 50%;
            padding: 0.4vw;
            color: white;
            text-align: center;
            font: 2vw Arial, sans-serif;
            width: 3vw;
            height: 3vw;
        }
    </style>
    <script>
        jQuery(document).ready(function ($) {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('c')) {
                $(".first-chat > a[data-conversation-id='" + urlParams.get('c') + "']").click();
            } else {
                $(".first-chat > a").click();
            }
        });
        $(".message-switcher").click(function () {
            $("#messages-container").load($(this).attr('data-sourse'));
        });

    </script>
@endsection


