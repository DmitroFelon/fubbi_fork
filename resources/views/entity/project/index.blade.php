@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{_i('Projects')}}</h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{_i('All projects assigned to this account')}}</h5>
            <div class="ibox-tools">
                <a target="_blank" href="{{route('projects.create')}}"
                   class="btn btn-primary btn-xs">{{_i('Create new project')}}</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row m-b-sm m-t-sm">
                @if(Auth::user()->role != 'client')
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <a href="{{action('ProjectController@index')}}" id="loading-example-btn"
                           class="btn btn-white btn-sm"><i
                                    class="fa fa-refresh">
                            </i> {{_i('Refresh')}}
                        </a>
                    </div>
                    {{Form::open(['action' => 'ProjectController@index', 'method' => 'get'])}}
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        {{ Form::select(
                               'user',
                               $filters['users'],
                               request('user'),
                               ['class' => 'form-control'])
                           }}
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        {{ Form::select(
                               'month',
                               $filters['months'],
                               request('month'),
                               ['class' => 'form-control'])
                        }}
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        {{ Form::select(
                           'status',
                           $filters['status'],
                           request('status'),
                           ['class' => 'form-control'])
                        }}
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> {{_i('Filter')}}</button>
                    </span>
                    </div>
                    {{Form::close()}}
                @endif()
            </div>
            <div class="project-list">
                <table class="table table-hover">
                    <tbody>
                    @foreach($projects as $project)
                        @include('entity.project.partials.row')
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">{{ $projects->links() }}</div>
            </div>
        </div>
    </div>
@endsection
