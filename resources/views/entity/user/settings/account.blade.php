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