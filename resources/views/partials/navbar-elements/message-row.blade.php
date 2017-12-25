<li>
    <a href="{{action('MessageController@index', ['c' => $message->data['conversation_id']])}}">
        <div>
            <i class="fa fa-envelope fa-fw"></i>
            <strong>{{\Musonza\Chat\Messages\Message::find($message->data['message_id'])->sender->name}}:</strong>
            <small>
                {{str_limit(\Musonza\Chat\Messages\Message::find($message->data['message_id'])->body, 7, ' ...') }}
            </small>
            <span class="pull-right text-muted small">
                {{ Musonza\Chat\Facades\ChatFacade::conversation($message->data['conversation_id'])->data['title'] }}
            </span>
        </div>
    </a>
</li>
<li class="divider"></li>