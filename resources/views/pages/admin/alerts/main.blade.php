@extends('master')

@section('content')
    <div class="ibox-content">
    @if(\Illuminate\Support\Facades\Auth::user()->unreadNotifications->isNotEmpty())
        <a href="{{url('notification/read/')}}" class="btn btn-primary">Mart all as read</a>
    @endif

    <div class="text-muted">Unread notifications:</div>
    <ul class="list-group">

        @each('partials.client.alerts.row', \Illuminate\Support\Facades\Auth::user()->unreadNotifications, 'notification', 'partials.client.alerts.emptry-row')

        <div class="text-muted">Old notifications:</div>

        @each('partials.client.alerts.row', \Illuminate\Support\Facades\Auth::user()->readNotifications, 'notification', 'partials.client.alerts.emptry-row')

    </ul>
    </div>
@endsection
