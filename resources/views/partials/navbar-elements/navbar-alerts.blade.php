<li class="dropdown">
    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
        <i class="fa fa-bell"></i>
        @if(count(\Illuminate\Support\Facades\Auth::user()->unreadNotifications) > 0)
            <span class="label label-warning">
                {{count(\Illuminate\Support\Facades\Auth::user()->unreadNotifications)}}
            </span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-messages">
        @each('partials.navbar-elements.alert-row',
            \Illuminate\Support\Facades\Auth::user()->unreadNotifications,
             'notification',
             'partials.navbar-elements.alert-row-empty'
        )
        <li>
            <div class="text-center link-block">
                <a href="{{url('alerts')}}">
                    <strong>{{__('See All Alerts')}}</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </li>
    </ul>
</li>