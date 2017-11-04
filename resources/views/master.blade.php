<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Fubbi</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ URL::to('css/app.css') }}" rel="stylesheet">
    </head>

    <header>
        @include('header')
    </header>

    <body class="container-fluid">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        @include('partials.left-sidebar')
    </div>

    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        @yield('content')
    </div>

    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        @include('partials.right-sidebar')
    </div>



    </body>

    <footer>
        @include('footer')
        <link href="{{ URL::to('js/app.js') }}" rel="stylesheet">
        @yield('script')
    </footer>

</html>
