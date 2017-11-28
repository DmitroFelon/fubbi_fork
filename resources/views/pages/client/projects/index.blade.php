@extends('master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>All projects assigned to this account</h5>
                        <div class="ibox-tools">
                            <a href="{{route('projects.create')}}" class="btn btn-primary btn-xs">Create new project</a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <table class="table table-hover">
                                <tbody>
                                @foreach($projects as $project)
                                    @include('partials.client.projects.card')
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--
        @foreach($projects as $project)
            @include('partials.client.projects.card')
        @endforeach
        <div class="project-add col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <div align="center" class="transparent">
                <i onclick="window.location.replace('{{route('projects.create')}}');" class="fa fa-plus fa-4x"></i>
            </div>
        </div>--}}
@endsection
