@include('partials.top-nav')

<div class="text-center header-content">
    <h2>header content</h2>
</div>

<div class="container">
    <div class="notifiations-area">
        @foreach(\App\Services\FlashMessage::get() as $notification)
            <div class="alert alert-dismissable fade in alert-{{$notification->type}}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{$notification->message}}
            </div>
        @endforeach
    </div>
</div>

<hr>