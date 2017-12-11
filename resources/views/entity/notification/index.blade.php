@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>{{__('Notifications')}}</h2>
        </div>
    </div>
@endsection

@section('content')

    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-push-1 col-lg-push-1">
                    <div class="row">
                        @if($has_unread_notifications)
                            <a href="{{url('notification/read/')}}" class="btn btn-default btn-xs pull-right">
                                {{__('Mart all as read')}}
                            </a>
                            <br>
                        @endif
                    </div>
                    <div class="activity-stream">
                        @each('entity.notification.partials.page-row', $page_notifications, 'notification', 'entity.notification.partials.page-row-empty')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
@endsection