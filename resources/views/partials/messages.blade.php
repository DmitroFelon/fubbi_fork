@if (session('error'))
    <div class="head-notification row wrapper border-bottom red-bg page-heading">
        <div class="col-lg-12">
            <h2 class="text-center">{{ session('error') }}</h2>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="head-notification row wrapper border-bottom bg-primary page-heading">
        <div class="col-lg-12">
            <h2 class="text-center">{{ session('success') }}</h2>
        </div>
    </div>
@endif


@if (session('info'))
    <div class="head-notification row wrapper border-bottom blue-bg page-heading">
        <div class="col-lg-12">
            <h2 class="text-center">{{ session('info') }}</h2>
        </div>
    </div>
@endif