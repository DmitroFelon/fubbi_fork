@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>{{_i('Statistic')}}</h2>
            <hr>
            {!! Form::open(['method' => 'get']) !!}
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="customer-select">{{_i('Customer')}}</label>
                        <select class="form-control" name="customer" id="customer-select">
                            <option value="">{{_i('All customers')}}</option>
                            @foreach($clients as $client)
                                <option
                                        {{(\Illuminate\Support\Facades\Request::input('customer') == $client->id) ? 'selected=selected':''}}
                                        value="{{$client->id}}">
                                    {{$client->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="date_from">{{_i('From')}}</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="date_from" name="date_from" type="text" class="form-control"
                                    value="{{$date_from}}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="date_to">{{_i('To')}}</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="date_to" name="date_to" type="text" class="form-control"
                                    value="{{$date_to}}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="input-group date">
                            <button class="btn btn-primary" type="submit">{{_i('Search')}}</button>
                            <a class="btn btn-default m-l-lg"
                               href="{{action('DashboardController@dashboard')}}">{{_i('Clear')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
       {{-- <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('New Articles')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div data-view="pages.admin.dashboard.widgets.articles.last" class="ibox-content preloaded">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div>--}}
        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Declined Articles')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content preloaded" data-view="pages.admin.dashboard.widgets.articles.declined">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Last Payments')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div style="display: none" data-view="pages.admin.dashboard.widgets.charges.last" class="ibox-content preloaded">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div>
        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Pending Payments')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div style="display: none" data-view="pages.admin.dashboard.widgets.charges.pending" class="ibox-content preloaded">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div>
        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Rejected Payments')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div style="display: none" class="ibox-content preloaded" data-view="pages.admin.dashboard.widgets.charges.rejected">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function ($) {
            $('#date_from').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $('#date_to').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
            var preloaded_erappers = $(".preloaded");
            preloaded_erappers.each(function (item) {
                $(this).load("/dashboard/preload/" + $(this).attr('data-view') + window.location.search);
            });
        });
    </script>
    <style>

    </style>

@endsection