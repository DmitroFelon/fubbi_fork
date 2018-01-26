@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>{{_i('Statistic')}}</h2>
            <hr>
            @include('pages.admin.dashboard.partials.search')
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
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
        </div> {{-- Decliened Articles widget --}}
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
                <div style="display: none" data-view="pages.admin.dashboard.widgets.charges.last"
                     class="ibox-content preloaded">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div> {{-- Last payment widget --}}
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
                <div style="display: none" data-view="pages.admin.dashboard.widgets.charges.pending"
                     class="ibox-content preloaded">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div> {{-- Pending payment widget --}}
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
                <div style="display: none" class="ibox-content preloaded"
                     data-view="pages.admin.dashboard.widgets.charges.rejected">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div> {{-- Rejected payments widget --}}
    </div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function ($) {

            /*
             * Init datepicker
             * */
            $('#date_from, #date_to').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            var preloaded_erappers = $(".preloaded");
            /*
             * Preload necessary widget from view composer
             * */
            preloaded_erappers.each(function (item) {
                $(this).load("/dashboard/preload/" + $(this).attr('data-view') + window.location.search);
            });
        });
    </script>
@endsection