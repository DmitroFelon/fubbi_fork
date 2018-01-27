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
        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"> {{-- Decliened Articles widget --}}
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

        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4"> {{-- Articles by rating section--}}
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Articles with 5 stars')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content preloaded" data-view="pages.admin.dashboard.widgets.articles.by_rate?rate=5&">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div>
        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4"> {{-- Articles by rating section--}}
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Articles with 4 stars')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content preloaded" data-view="pages.admin.dashboard.widgets.articles.by_rate?rate=4&">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div>
        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4"> {{-- Articles by rating section--}}
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Articles with less than 3 stars')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content preloaded" data-view="pages.admin.dashboard.widgets.articles.by_rate?rate=3&">
                    @include('partials.navbar-elements.spinner')
                </div>
            </div>
        </div>
    </div>
    <div class="row"> {{-- Payments section --}}
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
                var query = '';
                var base_url = "/dashboard/preload/" + $(this).attr('data-view');
                if (window.location.search) {
                    query = window.location.search.substr(1);
                }

                if (base_url.substr(-1) != '&') {
                    query = '?' + query;
                }

                console.log(base_url + query)

                $(this).load(base_url + query);
            });
        });
    </script>
@endsection