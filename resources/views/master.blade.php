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
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"/>
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
    <script>
        var stripe_pub = "{{config('services.stripe.key')}}";
    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{ URL::to('js/app.js') }}" rel="stylesheet"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://js.stripe.com/v2/"></script>
    @yield('script')
    @include('footer')
</footer>

</body>
</html>
