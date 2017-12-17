<li class="dropdown">
    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
        <i class="fa fa-bell"></i>
        @if($notifications->count())
            <span class="label label-warning">
                {{$notifications->count()}}
            </span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-messages">
        @each('partials.navbar-elements.alert-row',
            $notifications,
             'notification',
             'partials.navbar-elements.alert-row-empty'
        )
        <li>
            <div class="text-center link-block">
                <a href="{{url('notification')}}">
                    <strong>{{_i('See All Alerts')}}</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </li>
    </ul>
</li>