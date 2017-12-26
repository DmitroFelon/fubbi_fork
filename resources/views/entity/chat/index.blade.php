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
            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                <div class="ibox">
                    <div style="height: 600px" id="messages-container" class="ibox-content">
                        <div class="spinner-big">
                            <div class="sk-spinner sk-spinner-circle sk-spinner-big">
                                <div class="sk-circle1 sk-circle"></div>
                                <div class="sk-circle2 sk-circle"></div>
                                <div class="sk-circle3 sk-circle"></div>
                                <div class="sk-circle4 sk-circle"></div>
                                <div class="sk-circle5 sk-circle"></div>
                                <div class="sk-circle6 sk-circle"></div>
                                <div class="sk-circle7 sk-circle"></div>
                                <div class="sk-circle8 sk-circle"></div>
                                <div class="sk-circle9 sk-circle"></div>
                                <div class="sk-circle10 sk-circle"></div>
                                <div class="sk-circle11 sk-circle"></div>
                                <div class="sk-circle12 sk-circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        .sk-spinner-big {
            width: 30px !important;
            height: 100px !important;
        }

        .spinner-big {
            padding-top: 130px;
        }

        .chat-message.right > div > div > .message {
            margin-left: 100px;
        }

        .chat-message.left > div > div > .message {
            margin-right: 100px;
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
            var last_message_id = null;
            $(document).on("click", "button#send-message", function (e) {
                e.preventDefault();
                var formData = $("#chat-form").serialize();
                jQuery.ajax('/messages', {
                            method: "POST",
                            processData: false,
                            data: formData,
                            success: function (data) {

                            },
                            error: function (data) {
                                alert('some error')
                            }
                        }
                );
            });
        });


        $(".message-switcher").click(function () {
            $("#messages-container").load($(this).attr('data-sourse'), function () {

                $('#chat-discussion').scrollTop($('#chat-discussion')[0].scrollHeight);

                var conversation_id = $("#chat-id").val();

                Echo.join('conversation.' + conversation_id)
                        .here(function (users) {
                            console.table(users);
                        })
                        .joining(function (joiningMember, members) {
                            // runs when another member joins
                            console.table(joiningMember);
                        })
                        .leaving(function (leavingMember, members) {
                            // runs when another member leaves
                            console.table(leavingMember);
                        })
                        .listen('ChatMessage', function (e) {

                            var message_id = e.message_id;
                            var sender_id = e.sender_id;
                            var message = e.message;

                            $('#chat-discussion').append(message);

                            $(".chat-message[data-id='" + message_id + "']").removeClass('left');
                            $(".chat-message[data-id='" + message_id + "']").removeClass('right');
                            $(".chat-message[data-id='" + message_id + "']").addClass(
                                    (sender_id == user.id ? 'right' : 'left')
                            );

                            $('#chat-input').val('');
                            $('#chat-discussion').scrollTop($('#chat-discussion')[0].scrollHeight);
                        });

            });
        });
    </script>
@endsection


