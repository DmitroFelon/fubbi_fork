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
    <span class="text-muted small pull-right">
        Last modification: <i class="fa fa-clock-o"></i> 2:10 pm - 12.06.2014
    </span>
    <br><br>
    <div class="input-group">
        <input type="text" placeholder="Search client"
               class="input form-control">
        <span class="input-group-btn">
                <button type="button" class="btn btn btn-primary">
                    <i class="fa fa-search"></i>{{__('Search')}}
                </button>
        </span>
    </div>
    <div class="clients-list">
        <span class="pull-right small text-muted">{{__('Total')}}: <small>{{$users_count}}</small></span>
        <ul class="nav nav-tabs">
            @foreach(\App\Models\Role::all() as $role)
                <li class="{{$loop->first?'active':''}}">
                    <a data-toggle="tab" href="#tab-{{$role->name}}">
                        <i class="fa fa-user"></i> {{$role->display_name}}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach(\App\Models\Role::all() as $role)
                <div id="tab-{{$role->name}}" class="tab-pane {{$loop->first?'active':''}}">
                    <div class="full-height-scroll">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tbody>
                                @foreach($users[$role->name] as $user)
                                    <tr>
                                        <td class="client-avatar"><i class="fa fa-user fa-2x"></i></td>
                                        <td>
                                            <a target="_blank" href="{{url()->action('UserController@show', $user)}}">
                                                {{$user->name}}
                                            </a>
                                        </td>
                                        <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                        <td> {{$user->email}}</td>
                                        <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                        <td> {{$user->phone}}</td>
                                        <td class="contact-type"> <i class="fa fa-file-o"></i></td>
                                        <td>{{$user->projects->count()}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection