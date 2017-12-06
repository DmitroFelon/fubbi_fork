@if (session('error'))
    <div class="row wrapper border-bottom red-bg page-heading">
        <div class="col-sm-4 p-xs">
            <h3 class="">{{ session('error') }}</h3>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="row wrapper border-bottom green-bg page-heading">
        <div class="col-sm-4 p-xs">
            <h3 class="">{{ session('success') }}</h3>
        </div>
    </div>
@endif

@if (session('info'))
    <div class="row wrapper border-bottom blue-bg page-heading">
        <div class="col-sm-4 p-xs">
            <h3 class="">{{ session('info') }}</h3>
        </div>
    </div>
@endif