@extends('master')

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{_i('Add video')}}</h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">

            <img class="m-md" src="{{$video->thumbnail}}" alt="">

            {!! Form::model($video, ['method' => 'PUT', 'role'=>'form', 'route'=>['help_videos.update', $video]]) !!}

            {!! Form::bsText('name', null, _i('Name'), null, ['required'], 'text') !!}

            {!! Form::bsText('url', null, _i('Full url or Youtube id'), null, ['required'], 'text') !!}

            {!! Form::bsText('page', null, _i('Page'), null, ['required'], 'text') !!}

            {{Form::submit('Save Video', ['class' => 'form-control btn btn-primary'])}}

            {!! Form::close() !!}


        </div>
    </div>

@endsection