@if (session('error'))
    @foreach(collect(session('error')) as $message)
        <div class="head-notification row wrapper border-bottom red-bg page-heading">
            <div class="col-lg-12">
                <h2 class="text-center">{!! $message !!}</h2>
            </div>
        </div>
    @endforeach
@endif

@if (session('success'))
    @foreach(collect(session('success')) as $message)
        <div class="head-notification row wrapper border-bottom bg-primary page-heading">
            <div class="col-lg-12">
                <h2 class="text-center">{!! $message !!}</h2>
            </div>
        </div>
    @endforeach
@endif


@if (session('info'))
    @foreach(collect(session('info')) as $message)
        <div class="head-notification row wrapper border-bottom blue-bg page-heading">
            <div class="col-lg-12">
                <h2 class="text-center">{!! $message !!}</h2>
            </div>
        </div>
    @endforeach
@endif