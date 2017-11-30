@extends('master')

@section('content')
    <span class="text-muted small pull-right">Last modification: <i
                class="fa fa-clock-o"></i> 2:10 pm - 12.06.2014</span>
    <h2>Users</h2>
    <p>
        some text
    </p>
    <div class="input-group">
        <input type="text" placeholder="Search client"
               class="input form-control">
        <span class="input-group-btn">
                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Search</button>
        </span>
    </div>
    <div class="clients-list">
        <span class="pull-right small text-muted">1406 Elements</span>
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
                                        <td class="client-status"><span class="label label-primary">Active</span></td>
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
@endsection