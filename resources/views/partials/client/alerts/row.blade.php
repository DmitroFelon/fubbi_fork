<li class="list-group-item">

    @if($notification->unread())
        <a title="mark as read" href="{{url('notification/read/'.$notification->id)}}" class="close"><i class="fa fa-eye"></i></a>
    @endif

    {{json_encode($notification->data)}}
</li>