@extends('master')

@section('content')

    <div class="ibox-content">
    all: <br>

    <?php
    foreach (\Illuminate\Support\Facades\Auth::user()->notifications as $notification) {
        echo $notification->type .  json_encode($notification->data)."<br>";
    }
    ?>
    <hr>
    new: <br>
    <?php
    foreach (\Illuminate\Support\Facades\Auth::user()->unreadNotifications as $notification) {
        echo json_encode($notification->data)."<br>";
    }
    ?>
    </div>
@endsection