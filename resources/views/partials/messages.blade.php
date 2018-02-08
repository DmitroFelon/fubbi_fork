
<div class="container-fluid m-t-md">
    @if (session('error'))
        @foreach(collect(session('error')) as $message)
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {!! session()->pull('error') !!}
            </div>
        @endforeach
    @endif

    @if (session('success'))
        @foreach(collect(session('success')) as $message)
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    {!! session()->pull('success') !!}
                </div>
        @endforeach
    @endif


    @if (session('info'))
        @foreach(collect(session('info')) as $message)
            <div class="alert alert-info alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {!! session()->pull('info') !!}
            </div>
        @endforeach
    @endif
</div>

