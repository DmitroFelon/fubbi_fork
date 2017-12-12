@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{__('All plans')}}</h2>
        </div>
    </div>

@endsection

@section('content')

        <div class="ibox">
            <div class="ibox-title">
                <h5>{{__('')}}</h5>
                <div class="ibox-tools">
                    <a target="_blank" href="{{route('plans.create')}}"
                       class="btn btn-primary btn-xs">{{__('Create new plan')}}</a>
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