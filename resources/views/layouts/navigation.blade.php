<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">

            @auth
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">
                                        {{\Illuminate\Support\Facades\Auth::user()->name}}
                                    </strong>
                                </span>
                                <span class="text-muted text-xs block">
                                    {{__('Fast actions')}}<b class="caret"></b>
                                </span>
                            </span>
                        </a>
                        @auth
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li>
                                <a href="#"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        @endauth
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                @foreach($items as $name => $link)
                    <li class="{{isActiveRoute($link)}}">
                        <a href="{{$link}}">
                            <i class="fa fa-th-large"></i> {{-- TODO set correct icons --}}
                            <span class="nav-label">{{$name}}</span>
                            @if($link == '/alerts')
                                <span class="badge">
                                    {{ \Illuminate\Support\Facades\Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endforeach
            @endauth

            @guest
            <li class="nav-header">
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="{{isActiveRoute('login')}}">
                <a href="{{url('login')}}">
                    <i class="fa fa-sign-in"></i>
                    <span class="nav-label">{{__('Login')}}</span>
                </a>
            </li>
            <li class="{{isActiveRoute('register')}}">
                <a href="{{url('register')}}">
                    <i class="fa fa-plus"></i>
                    <span class="nav-label">{{__('Registration')}}</span>
                </a>
            </li>
            @endguest
        </ul>
    </div>
</nav>
