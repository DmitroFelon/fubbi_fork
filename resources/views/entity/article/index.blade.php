@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                @if(isset($project))
                    <h5> {{$project->name}} </h5>
                    <div class="ibox-tools">
                        <a target="_blank" href="{{url()->action('Project\ArticlesController@create', [$project])}}"
                           class="btn btn-primary btn-xs">{{_i('Create new Article')}}</a>
                    </div>
                @else
                    <h5>
                        {{_i('All articles')}}
                    </h5>
                @endif
            </div>
            <div class="ibox-content">
                <div class="row m-b-sm m-t-sm">
                    @if(Auth::user()->role != \App\Models\Role::CLIENT)
                        @if(isset($project))
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <a href="{{action('Project\ArticlesController@index', $project)}}"
                                   id="loading-example-btn"
                                   class="btn btn-white btn-sm"><i
                                            class="fa fa-refresh">
                                    </i> {{_i('Refresh')}}
                                </a>
                            </div>
                            {{Form::open(['action' => ['Project\ArticlesController@index', $project], 'method' => 'get'])}}
                        @else
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <a href="{{action('ArticlesController@index')}}" id="loading-example-btn"
                                   class="btn btn-white btn-sm"><i
                                            class="fa fa-refresh">
                                    </i> {{_i('Refresh')}}
                                </a>
                            </div>
                            {{Form::open(['action' => ['ArticlesController@index'], 'method' => 'get'])}}
                        @endif
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            {{ Form::select(
                                   'type',
                                   $filters['types'],
                                   request('type'),
                                   ['class' => 'form-control'])
                               }}
                        </div>
                        @isset($project)
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            {{ Form::select(
                                   'status',
                                   $filters['statuses'],
                                   request('status'),
                                   ['class' => 'form-control'])
                               }}
                        </div>
                        @endisset
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> {{_i('Filter')}}</button>
                    </span>
                        </div>
                        {{Form::close()}}
                    @endif()
                </div>
                <hr>
                <div class="project-list">
                    <span class="pull-right">{{_i('Count')}} : {{$articles->count()}}</span>
                    <table class="table table-hover footable">
                        <thead>
                        <tr>
                            <th class="footable-sortable"></th>
                            <th class="footable-sortable">{{_i('Status')}}</th>
                            <th>{{_i('Type')}}</th>
                            <th class="footable-sortable">{{_i('Project')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                            @include('entity.article.partials.row')
                        @endforeach
                        </tbody>
                    </table>
                    {{$articles->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection

