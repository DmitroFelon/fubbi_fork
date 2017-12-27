<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fubbi</title>
    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}"/>
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}"/>
</head>

@include('header')

<body>

<!-- Wrapper-->
<div id="wrapper">
    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>

    <!-- Navigation -->
@include('layouts.navigation')


<!-- Page wraper -->
    <div id="page-wrapper" class="gray-bg">

    @auth
    @include('layouts.topnavbar')
    @endauth

    @yield('before-content')

    @include('partials.messages')

    <!-- Main view  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- End Main view  -->

    @yield('after-content')

    <!-- Footer -->
        @include('footer')

    </div>
    <!-- End page wrapper-->

</div>
<!-- End wrapper-->
<script>
    var stripe_pub = "{{config('services.stripe.key')}}";
    var user = @json((\Illuminate\Support\Facades\Auth::check())?\Illuminate\Support\Facades\Auth::user():'');
    var conversation_id = null;
    var is_chat = false;
</script>

@yield('before-scripts')

<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>

@yield('scripts')

<script>
    Echo.private('App.User.' + user.id)
            .notification(function (notification) {
                if (notification.type == 'App\\Notifications\\Chat\\Message') {
                    if (conversation_id != notification.conversation_id) {
                        $('#topnav-messages-list').prepend(notification.navbar_message);
                        var messages_count_wrapper = $("#message-notifications-count");
                        var count = parseInt(messages_count_wrapper.html());
                        if (!count || isNaN(count)) {
                            count = 0;
                        }

                        count = count + 1;

                        messages_count_wrapper.html(count.toString())
                    } else {
                        $.get("{{url('messages/read/')}}/" + notification.conversation_id);

                    }
                } else {
                    if (notification.hasOwnProperty('navbar_message')) {

                        $('#topnav-alerts-list').prepend(notification.navbar_message);
                        var alerts_count_wrapper = $("#alerts-notifications-count");
                        var count = parseInt(alerts_count_wrapper.html());

                        if (!count || isNaN(count)) {
                            count = 0;
                        }

                        count = count + 1;

                        alerts_count_wrapper.html(count.toString())
                        console.log(parseInt(alerts_count_wrapper.html()))
                    }
                }
            });
</script>

</body>
</html>