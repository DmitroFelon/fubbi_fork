<div class="row">

    {{ Form::open(['method' => 'POST', 'action' => 'MessageController@store' ]) }}
    {{Form::hidden('conversation', $conversation)}}
    <div class="col-md-10">
        <div class="chat-discussion">
            @each('entity.chat.partials.message', $chat_messages, 'chat_message')
        </div>
        @include('entity.chat.partials.input')
    </div>
    <div class="col-md-2">
        <div class="chat-users">
            <div class="users-list">
                @each('entity.chat.partials.participant', $participants, 'user')
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            {{Form::submit('Send', ['class' => 'btn btn-primary btn-lg'])}}
        </div>
    </div>
    {{Form::close()}}
</div>
