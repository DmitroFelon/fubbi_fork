@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>
                {{_i('Teams board')}}
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        @each('entity.team.partials.card', $teams, 'team' )
    </div>
@endsection
