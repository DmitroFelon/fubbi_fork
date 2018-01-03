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
    var help_video_src = "{{$help_video_src}}";
</script>

<div id="help-video-wrapper">
    <button id="question-btn" class="btn btn-warning btn-circle btn-lg">
        <i class="fa fa-question"></i>
    </button>
</div>

@yield('before-scripts')

<script src="{!! asset('js/lib.js') !!}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>

@yield('scripts')


<script>
    jQuery(document).ready(function ($) {
        var _project_id = $("input[name=_project_id]").val();
        dz = $("#compliance_guideline-group").dropzone(
                {
                    url: "/projects/" + _project_id + "/prefill_files",
                    paramName: 'compliance_guideline',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function () {
                        thisDropzone = this;
                        var files = [];
                        $.get('/projects/' + _project_id + '/get_stored_files',
                                {collection: 'compliance_guideline'},
                                function (data) {
                                    data.forEach(function (item) {
                                        thisDropzone.emit("addedfile", item);
                                        thisDropzone.options.thumbnail.call(thisDropzone, item, item.url);
                                        thisDropzone.emit("complete", item);
                                    });
                                });
                    },

                    addRemoveLinks: true,
                    removedfile: function (item) {
                        $.get('/projects/' + item.model_id + '/remove_stored_file/' + item.id);
                        var _ref;
                        return (_ref = item.previewElement) != null ? _ref.parentNode.removeChild(item.previewElement) : void 0;
                    }
                });
    });
</script>

</body>
</html>