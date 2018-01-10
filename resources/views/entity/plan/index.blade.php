@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{_i('All plans')}}</h2>
        </div>
    </div>

@endsection

@section('content')

        <div class="ibox">
            <div class="ibox-title">
                <h5>{{_i('')}}</h5>
                <div class="ibox-tools">

                </div>
            </div>
            <div class="ibox-content">
                <div class="project-list">
                    <table class="table table-hover">
                        <tbody>
                        @foreach($plans as $plan)
                            @include('entity.plan.partials.card')
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection