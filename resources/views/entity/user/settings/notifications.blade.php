{{Form::open(['method' => 'POST', 'action' => 'SettingsController@save', 'id' => 'settings-main-notifications'])}}
<h3 class="text-center">{{_i('Disable project notifications')}}</h3>
<br>
<div class="row">
    @foreach($project_notifications_checkboxes as $name => $data)
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            @include('entity.user.partials.checkbox')
        </div>
    @endforeach
</div>
@role([\App\Models\Role::CLIENT])
<br>
<h3 class="text-center">{{_i('Disable billing notifications')}}</h3>
<br>
<div class="row">
    @foreach($billing_notification_checkboxes as $name => $data)
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            @include('entity.user.partials.checkbox')
        </div>
    @endforeach
</div>
@endrole()
{{Form::submit(_i('Save'), ['class' => 'btn btn-primary m-t-md'])}}

{{Form::close()}}