@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                {{$project->name}}
            </div>
            <div class="ibox-content">
                <div>
                    {{$project->client->name}}
                </div>
                <div>
                    {{$project->subscription->created_at->format('Y')}}
                </div>
                <div>
                    {{$project->subscription->created_at->format('F')}}
                </div>
            </div>
        </div>
    </div>
@endsection

