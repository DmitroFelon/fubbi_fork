@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{_i('Users')}}</h2>
        </div>
    </div>
@endsection

@section('content')
<div class="ibox">
    <div class="ibox-title">
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        @include('entity.user.partials.search')
        <div class="clients-list">
            <span class="pull-right small text-muted">{{_i('Total')}}: <small>{{$users->count()}}</small></span>
            <ul class="nav nav-tabs">
                @foreach($roles as $role)
                    @include('entity.user.partials.top-tab')
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($groupedByRoles as $role => $users)
                    @include('entity.user.partials.tab')
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection