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

<body>

<!-- Wrapper-->
<div id="wrapper">

    <!-- Navigation -->
    @include('layouts.navigation')


    <!-- Page wraper -->
    <div id="page-wrapper" class="gray-bg">

        @auth
        <!-- Page wrapper -->
        @include('layouts.topnavbar')
        @endauth

        <!-- Main view  -->

        @yield('content')

        <!-- Footer -->
        @include('footer')

    </div>
    <!-- End page wrapper-->

</div>
<!-- End wrapper-->

<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>

@section('scripts')
@show

</body>
</html>