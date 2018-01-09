@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{_i('Project details')}}</h2>
        </div>
    </div>
    @if(!$project->hasWorker() and \Illuminate\Support\Facades\Auth::user()->hasInvitetoProject($project->id) )
        @include('entity.project.partials.form.invite')
    @endif
@endsection

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
        <div class="col col-lg-12 col-xs-12 ">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{$project->name}}</h5>
                    <div class="ibox-tools">
                        @include('entity.project.partials.show.tools')
                    </div>
                </div>
                <div class="ibox-content">
                    @include('entity.project.partials.show.head')
                </div>
            </div>
        </div>

        <div class="col col-lg-6 col-xs-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Quiz result')}}</h5>
                    <div class="ibox-tools">
                        <a href="{{url()->action('ProjectController@edit', ['id' => $project->id, 's' => 'quiz'])}}"
                           class="btn btn-primary btn-xs m-r-sm p-w-sm">
                            {{_i('Edit')}}
                        </a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none">
                    @include('entity.project.partials.show.metadata')
                </div>
            </div>
        </div>

        <div class="col col-lg-6 col-xs-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Media files')}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content " style="display: none">
                    @include('entity.project.partials.show.media')
                </div>
            </div>
        </div>

        <div class="col col-lg-6 col-xs-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Keywords')}}</h5>
                    <div class="ibox-tools">
                        <a href="{{url()->action('ProjectController@edit', ['id' => $project->id, 's' => 'keywords'])}}"
                           class="btn btn-primary btn-xs m-r-sm p-w-sm">
                            {{_i('Edit')}}
                        </a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content " style="display: none">
                    @includeWhen(!empty($keywords), 'entity.project.partials.show.keywords', ['iterable' => $keywords])
                </div>
            </div>
        </div>

        <div class="col col-lg-6 col-xs-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{_i('Questions')}}</h5>
                    <div class="ibox-tools">
                        <a href="{{url()->action('ProjectController@edit', ['id' => $project->id, 's' => 'keywords'])}}"
                           class="btn btn-primary btn-xs m-r-sm p-w-sm">
                            {{_i('Edit')}}
                        </a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content " style="display: none">
                    @includeWhen(!empty($keywords_questions), 'entity.project.partials.show.keywords', ['iterable' => $keywords_questions])
                </div>
            </div>
        </div>

        @role(['admin'])

        @if($project->requireWorkers())
            <div class="col col-lg-6 col-xs-12 ">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{_i('Attach workers')}}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content " style="display: none">
                        @include('entity.project.partials.show.invite-workers')
                    </div>
                </div>
            </div>
        @endif

        @if($project->workers->isEmpty() and $project->requireWorkers())
            <div class="col col-lg-6 col-xs-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{_i('Attach team')}}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content" style="display: none">
                        @include('entity.project.partials.show.invite-team')
                    </div>
                </div>
            </div>
        @endif

        @endrole
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
        <div class="ibox p-w-xs">
            <div class="ibox-title">
                <h5>{{_i('Activity')}}</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-down"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content inspinia-timeline">
                @foreach($project->activity()->where('log_name', '!=', 'default')->orderBy('id', 'desc')->limit(10)->get() as $activity)
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 date">
                                <div class="row">
                                    <i class="fa {{$project->getTimelineIcon($activity->log_name)}}"></i>
                                </div>
                                <div class="row">
                                    <small class="text-navy">{{$activity->created_at->diffForHumans()}}</small>
                                </div>
                                <br/>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 content {{($loop->first) ? 'no-top-border':'' }}">
                                <p class="m-b-xs"><strong>{{str_replace('_', '->', $activity->log_name)}}</strong></p>
                                <p>{{$activity->description}}</p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



@endsection