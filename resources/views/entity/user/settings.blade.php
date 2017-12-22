@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{_i('Settings')}}</h2>
        </div>
    </div>
@endsection



@section('content')

    <div class="ibox">
        <div class="ibox-title"></div>
        <div class="ibox-content">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-main">
                            <i class="fa fa-user"></i> {{_i('Profile')}}
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-notifications">
                            <i class="fa fa-bell "></i> {{_i('Notifications')}}
                        </a>
                    </li>
                    @role(['client'])
                    <li class="">
                        <a data-toggle="tab" href="#tab-billing">
                            <i class="fa fa-credit-card "></i> {{_i('Billling info')}}
                        </a>
                    </li>
                    @endrole

                </ul>
                <div class="tab-content">
                    <div id="tab-main" class="tab-pane active">
                        <div class="panel-body">
                            {{Form::model(\Illuminate\Support\Facades\Auth::user(), ['id' => 'settings-main-form', 'method' => 'PATCH', 'route' => ['users.update', \Illuminate\Support\Facades\Auth::user()]   ]) }}

                            <h3 class="text-center">{{_i('Contact')}}</h3>

                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    {!! Form::bsText('phone', null, _i('Phone'), null, [], 'text') !!}
                                </div>
                            </div>

                            <h3 class="text-center">{{_i('Change Pasword')}}</h3>

                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    {!! Form::bsText('password', null, _i('Password'), null, [], 'password') !!}
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    {!! Form::bsText('password_confirmation', null, _i('Repeat Password'), null, [], 'password') !!}
                                </div>
                            </div>

                            {{Form::submit(_i('Save'), ['class' => 'btn btn-primary'])}}

                            {{Form::close()}}
                        </div>
                    </div>
                    <div id="tab-notifications" class="tab-pane">

                        <div class="panel-body">
                            {{Form::open(['method' => 'POST', 'action' => 'SettingsController@save', 'id' => 'settings-main-notifications'])}}

                            <h3 class="text-center">{{_i('Project')}}</h3>
                            <br>
                            <div class="row">
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="i-checks">
                                        <label>
                                            <input
                                                    class="keywords-checkbox"
                                                    type="checkbox"
                                                    name="notifications[status]"
                                                    value="true"> <i></i>
                                            {{_i('Project status update')}}
                                        </label>
                                    </div>
                                    <div class="text-muted">{{_i('Receive email when someone change a project status')}}</div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="i-checks">
                                        <label>
                                            <input
                                                    class="keywords-checkbox"
                                                    type="checkbox"
                                                    name="notifications[material]"
                                                    value="true"> <i></i>
                                            {{_i('Project material update')}}
                                        </label>
                                    </div>
                                    <div class="text-muted">{{_i('Receive email when someone upload a new meterial')}}</div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <div class="i-checks">
                                        <label>
                                            <input
                                                    class="keywords-checkbox"
                                                    type="checkbox"
                                                    name="notifications[message]"
                                                    value="true"> <i></i>
                                            {{_i('Project messages')}}
                                        </label>
                                    </div>
                                    <div class="text-muted">{{_i('Receive email when someone leave a message on related project')}}</div>
                                </div>
                            </div>


                            {{Form::submit(_i('Save'), ['class' => 'btn btn-primary'])}}

                            {{Form::close()}}
                        </div>

                    </div>
                    @role(['client'])
                    <div id="tab-billing" class="tab-pane">
                        <div class="panel-body">
                            <strong>Donec quam felis</strong>

                            <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among
                                the stalks, and grow familiar with the countless indescribable forms of the insects
                                and flies, then I feel the presence of the Almighty, who formed us in his own image, and
                                the breath </p>

                            <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss
                                of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                                sense of mere tranquil existence, that I neglect my talents. I should be incapable of
                                drawing a single stroke at the present moment; and yet.</p>
                        </div>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>

@endsection