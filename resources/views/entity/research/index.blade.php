@extends('master')


@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{_i('Research Tool')}}</h5>
        </div>
        <div class="ibox-content">
            {!! Form::bsText('theme', null, _i('Keyword'), '', ['id' => 'theme'] ) !!}
            {!! Form::bsText('country',null, _i('Country'), '', ['id' => 'country', 'list' => 'countries'] ) !!}
            @include('entity.research.partials.countries')
            <button id="research" class="btn btn-primary">{{_('Research')}}</button>

            <div style="display: none;" id="result" class="m-t-md"></div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        jQuery(document).ready(function ($) {

            $('#research').on('click', function () {
                var theme = $('#theme').val();
                var country = $('#country').val();

                var sources = [
                    "{{ \App\Services\Api\KeywordTool::SOURCE_GOOGLE }}",
                    "{{ \App\Services\Api\KeywordTool::SOURCE_YOUTUBE }}",
                    "{{ \App\Services\Api\KeywordTool::SOURCE_BING }}",
                    "{{ \App\Services\Api\KeywordTool::SOURCE_AMAZON }}",
                    "{{ \App\Services\Api\KeywordTool::SOURCE_EBAY }}",
                    "{{ \App\Services\Api\KeywordTool::SOURCE_APP_STORE }}",
                ];

                $("#result").show();
                $("#result").html('')

                sources.forEach(function (source) {
                    $.get('{{action('ResearchController@load')}}', {
                        theme: theme,
                        country: country,
                        source: source
                    }, function (data) {

                        $("#result").append(data);
                    });
                });
            });
        });
    </script>
@endsection

