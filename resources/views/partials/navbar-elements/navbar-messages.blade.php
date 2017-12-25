<li class="dropdown">
    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
        <i class="fa fa-envelope"></i>  <span class="label label-primary">{{($messages->count() > 0) ? $messages->count() : ''}}</span>
    </a>
    <ul class="dropdown-menu dropdown-alerts">

        @each('partials.navbar-elements.message-row', $messages, 'message', 'partials.navbar-elements.message-row-empty')

        <li>
            <div class="text-center link-block">
                <a href="{{url('messages')}}">
                    <strong>{{_i('See All Messages')}}</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </li>
    </ul>
</li>