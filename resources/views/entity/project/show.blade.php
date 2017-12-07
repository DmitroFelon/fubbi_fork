@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{__('Project details')}}</h2>
        </div>
    </div>

    @if(!$project->hasWorker() and \Illuminate\Support\Facades\Auth::user()->hasInvitetoProject($project->id) )
        @include('entity.project.partials.form.invite')
    @endif
@endsection

@section('content')
    <div class="ibox">
        <div class="ibox-content">
            @include('entity.project.partials.show.head')

            {{--Metadata block start--}}
            @include('entity.project.partials.show.metadata')
            {{--Metadata block end--}}

            {{--Media block start--}}
            @include('entity.project.partials.show.media')
            {{--Media block end--}}
        </div>
    </div>

    @role(['writer'])
    <div class="ibox">
        <div class="ibox-content">
            @include('entity.project.worker-area.writer.main')
        </div>
    </div>
    @endrole

@endsection