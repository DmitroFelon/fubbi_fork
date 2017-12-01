
<div class="stream">
    <div class="stream-badge">
        <i class="fa fa-{{\App\Notifications\NotificationPayload::getIcon($notification->type)}}"></i>
    </div>
    <div class="stream-panel">
        <div class="stream-info">
            @if(isset($notification->data['link']))
                <a class="client-link" target="_blank" href="{{$notification->data['link']}}">
                    {{$notification->data['message']}}
                    <i class="fa fa-level-up"></i>
                </a>
            @else
                {{$notification->data['message']}}
            @endif
            <span class="date">{{$notification->created_at->diffForHumans()}}</span>
            @if($notification->unread())
                <a title="mark as read" href="{{url('notification/read/'.$notification->id)}}" class="close pull-right">
                    <i class="fa fa-eye"></i>
                </a>
            @endif
        </div>
    </div>

</div>


