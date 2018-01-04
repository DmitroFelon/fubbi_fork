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
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <ul class="nav nav-tabs">
                    @foreach($conversations as $conversation)
                        <li class="chat-nav-link {{($loop->first)?'active first-chat ':''}}">
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
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <div class="ibox">
                    <div style="height: 600px" id="messages-container" class="ibox-content">
                        @if($has_conversations)
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
                        @else
                            {{_i('No active conversations')}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <style>

    </style>
    <script>
        jQuery(document).ready(function ($) {
            //get necessary chat id
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('c')) {
                $(".first-chat > a[data-conversation-id='" + urlParams.get('c') + "']").click();
            } else {
                $(".first-chat > a").click();
            }

            //send message
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
            //load necessary chat
            $(".message-switcher").click(function () {
                $(".message-switcher").parent().removeClass('active');
                $(this).parent().addClass('active');
                $("#messages-container").load($(this).attr('data-sourse'), function () {
                    //scroll down
                    $('#chat-discussion').scrollTop($('#chat-discussion')[0].scrollHeight);
                    if (conversation_id) {
                        //leave the current chat before joining the new one
                        Echo.leave('conversation.' + conversation_id);
                    }
                    conversation_id = $("#chat-id").val();

                    var old_notifications = $(".top-message-list-item[data-conversation-id='" + conversation_id + "']");

                    //clear notifications from curent chat
                    old_notifications.each(function (i, obj) {
                        obj.remove();
                        $(".divider[data-divider-id='" + conversation_id + "']").remove();
                        var messages_count_wrapper = $("#message-notifications-count");
                        var count = parseInt(messages_count_wrapper.html());

                        if (count == 1) {
                            messages_count_wrapper.html('')
                            return;
                        }
                        messages_count_wrapper.html(count - 1)
                    });

                    Echo.join('conversation.' + conversation_id)
                            .here(function (users) {
                                $(".chat-user-status").addClass('label-danger');
                                users.forEach(function (user) {
                                    console.log(user.id)
                                    var user_id = user.id
                                    var wrapper = $(".chat-user-status[data-user-id='" + user_id + "']");
                                    wrapper.removeClass('label-danger');
                                    wrapper.addClass('label-primary');
                                    wrapper.html("Online");
                                });
                            })
                            .joining(function (joiningMember, members) {
                                console.log('joining')
                                var user_id = joiningMember.id
                                var wrapper = $(".chat-user-status[data-user-id='" + user_id + "']");
                                wrapper.removeClass('label-danger');
                                wrapper.addClass('label-primary');
                                wrapper.html("Online");
                            })
                            .leaving(function (leavingMember, members) {
                                console.log('leaving')

                                var user_id = leavingMember.id
                                var wrapper = $(".chat-user-status[data-user-id='" + user_id + "']");
                                wrapper.removeClass('label-primary');
                                wrapper.addClass('label-danger');
                                wrapper.html("Offline");
                            })
                            .listen('ChatMessage', function (e) {

                                var message_id = e.message_id;
                                var sender_id = e.sender_id;
                                var message = e.message;

                                $('#chat-discussion').append(message);

                                var message_wrapper = $(".chat-message[data-id='" + message_id + "']");

                                message_wrapper.removeClass('left');
                                message_wrapper.removeClass('right');

                                message_wrapper.addClass((sender_id == user.id ? 'right' : 'left'));

                                $('#chat-input').val('');
                                $('#chat-discussion').scrollTop($('#chat-discussion')[0].scrollHeight);
                            });

                });
            });
        });
    </script>
@endsection


