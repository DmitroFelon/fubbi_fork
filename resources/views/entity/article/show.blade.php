@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title"></div>
            <div class="ibox-content">
                {{$article->author->email}}
            </div>
        </div>
    </div>
@endsection

