<div class="chat-message left">
    <div class="row">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
            <div class="role-placeholder">
                A
            </div>
        </div>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
            <div class="message">
                <a class="message-author" href="#"> {{$chat_message->sender->name}} </a>
                <span class="message-date"> {{$chat_message->created_at}} </span>
                <span class="message-content">
                {{$chat_message->body}}
                </span>
            </div>
        </div>
    </div>
</div>