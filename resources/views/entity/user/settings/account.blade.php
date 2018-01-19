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

@if($user->isWorker())

    <h3 class="text-center">{{_i('Address')}}</h3>

    <div class="row">

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            {!! Form::bsText('address_line_1', null, _i('Address Line 1'), null, [], 'text') !!}
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            {!! Form::bsText('address_line_2', null, _i('Address Line 2'), null, [], 'text') !!}
        </div>

    </div>

    <div class="row">

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            {!! Form::bsText('zip', null, _i('Zip/Postal Code'), null, [], 'text') !!}
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            {!! Form::bsText('city', null, _i('City'), null, [], 'text') !!}
        </div>

    </div>

    <div class="row">

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            {!! Form::bsText('country', null, _i('Country'), null, [], 'text') !!}
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            {!! Form::bsText('state', null, _i('State/Province'), null, [], 'text') !!}
        </div>

    </div>

    <h3 class="text-center">{{_i('Additional')}}</h3>

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {!! Form::bsText('how_did_you_find_us', null, _i('How Did You find us?'), null, [], 'text') !!}
        </div>

    </div>

@endif


{{Form::submit(_i('Save'), ['class' => 'btn btn-primary'])}}

{{Form::close()}}