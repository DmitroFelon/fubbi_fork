@extends('master')

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{_i('Video "%s"', [$video->name])}}</h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            <iframe id="ytplayer" type="text/html" width="640" height="360"
                    src="http://www.youtube.com/embed/{{$video->youtube_id}}?autoplay=0&fs=1"
                    frameborder="0"></iframe>
        </div>
    </div>

@endsection