@extends('master')

@section('content')

    all: <br>

    <?php
    foreach (\Illuminate\Support\Facades\Auth::user()->notifications as $notification) {
        echo $notification->type .  json_encode($notification->data)."<br>";
        $notification->markAsRead();
    }
    ?>
    <hr>
    new: <br>
    <?php
    foreach (\Illuminate\Support\Facades\Auth::user()->unreadNotifications as $notification) {
        echo json_encode($notification->data)."<br>";
    }
    ?>
@endsection