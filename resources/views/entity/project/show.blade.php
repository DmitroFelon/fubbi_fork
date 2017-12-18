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
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>{{$project->name}}</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('entity.project.partials.show.head')
            </div>
        </div>
    </div>

    <div class="col col-lg-6">
        <div class="ibox">
            <div class="ibox-title">
                <h5>{{_i('Quiz result')}}</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('entity.project.partials.show.metadata')
            </div>
        </div>
    </div>

    <div class="col col-lg-6">
        <div class="ibox">
            <div class="ibox-title">
                <h5>{{_i('Media files')}}</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('entity.project.partials.show.media')
            </div>
        </div>
    </div>

    @role(['account_manager', 'admin', 'writer'])
        @include('entity.project.worker-area.writer.main')
    @endrole

    @include('entity.comment.component', ['comments' => $project->comments])
@endsection