@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{__('Users')}}</h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="ibox-content">
        <form method="get" class="input-group">
            <input type="hidden" name="user-role" id="user-role" value="admin">
            <input type="text"
                   value="{{\Illuminate\Support\Facades\Request::input('user-search')}}"
                   name="user-search"
                   placeholder="{{__('Search user')}}"
                   class="input form-control">
            <span class="input-group-btn">
                        <button type="submit" class="btn btn btn-primary">
                            <i class="fa fa-search"></i>{{__('Search')}}
                        </button>
                </span>
        </form>
        <div class="clients-list">
            <span class="pull-right small text-muted">{{__('Total')}}: <small>{{$users->count()}}</small></span>
            <ul class="nav nav-tabs">
                @foreach($roles as $role)
                    <li class="{{(request()->input('user-role') == $role->name or !request()->input('user-role') and $loop->first)
                                    ?'active'
                                    :''}}">
                        <a class="no-paddings" onclick="$('#user-role').val('{{$role->name}}')" data-toggle="tab"
                           href="#tab-{{$role->name}}">
                            <i class="fa fa-user"></i> {{$role->display_name}}
                            @if(isset($groupedByRoles[$role->name]) and $groupedByRoles[$role->name]->count()>0)
                                <span class="badge badge-primary">
                                    {{$groupedByRoles[$role->name]->count()}}
                                </span>
                            @else
                                <span class="badge">
                                    0
                                </span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($groupedByRoles as $role => $users)
                    @include('entity.user.partials.tab')
                @endforeach
            </div>
        </div>
    </div>
@endsection