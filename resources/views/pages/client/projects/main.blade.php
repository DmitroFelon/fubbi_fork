@extends('master')

@section('content')
    @foreach($projects as $project)
        @include('partials.client.projects.card')
    @endforeach
    <div class="project-add col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div align="center" class="transparent">
            <i onclick="window.location.replace('{{url('/projects/add')}}');" class="fa fa-plus fa-4x"></i>
        </div>
    </div>
@endsection

<style>
    .project-card{
        padding: 1em;
        color: white;
        font-size: 1.2em;
    }
    .project-card>div{
        background-color: #ffc675;
        height: 12em;
        padding: 1em;
    }
    .project-add>div>i{
        padding: 30% 0;
        color: lightgreen;
    }
    .project-add>div>i:hover{
        cursor: pointer;
    }
    .transparent{
        background-color: rgba(0,0,0,0)!important;
    }
    .project-workers{
        position: absolute;
        bottom: 1.5em;
    }
</style>