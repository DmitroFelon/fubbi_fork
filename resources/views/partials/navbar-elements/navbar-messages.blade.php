<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
    <i class="fa fa-envelope"></i>  <span id="message-notifications-count" class="label label-primary">{{($message_notifications->count() > 0) ? $message_notifications->count() : ''}}</span>
</a>
<ul class="dropdown-menu dropdown-alerts">

    @each('partials.navbar-elements.message-row', $message_notifications->take(10), 'message_notification', 'partials.navbar-elements.message-row-empty')

    <li>
        <div class="text-center link-block">
            <a href="{{url('messages')}}">
                <strong>{{_i('See All Messages')}}</strong>
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </li>
</ul>