<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fubbi</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ URL::to('css/app.css') }}" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{ URL::to('js/app.js') }}" rel="stylesheet"></script>
</head>
<header>
    @include('header')
</header>
<body>

<main role="main" class="container-fluid">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        @include('partials.left-sidebar')
    </div>

    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        @yield('content')
    </div>

    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        @include('partials.right-sidebar')
    </div>
</main>

<footer>
    @yield('script')

    @include('footer')
</footer>

</body>
</html>
