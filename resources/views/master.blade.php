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
</script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>

@section('scripts')
@show

</body>
</html>