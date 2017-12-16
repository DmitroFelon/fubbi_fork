<div class="col-lg-4">
    <div class="ibox">
        <div class="ibox-title">
            <a href="{{url()->action('TeamController@edit', $team)}}"
               class="btn btn-white btn-xs pull-right">
                {{_i('Edit team')}}
            </a>
            <h5>{{$team->name}}</h5>
        </div>
        <div class="ibox-content">
            <h4>{{_i('Info about')}} {{$team->name}}</h4>
            <p>
                {{$team->description}}
            </p>
            <div class="row  m-t-sm">
                <div class="col-sm-4">
                    <small>{{_i('Active Projects')}}</small>
                    1
                </div>
                <div class="col-sm-4">
                    <small>{{_i('Total Projects')}}</small>
                    12
                </div>
                <div class="col-sm-4">
                    <small>{{_i('Rating')}}</small>
                </div>
            </div>
            <hr>
            <div class="team-members">
                <h4>{{_i('Team Members')}}</h4>
                @foreach($team->users as $user)
                    <a target="_blank" href="{{url()->action('UserController@show', $user)}}">
                        {{--TODO replace with avatar--}}
                        {{$user->name}}
                    </a>
                    @if($user->id == $team->owner_id)
                        <span class="label label-primary pull-right">{{_i('Owner')}}</span>
                    @else
                        <span class="label label-default pull-right">
                                        {{$user->roles()->first()->display_name}}
                                    </span>
                    @endif
                    <br>
                @endforeach
            </div>
        </div>
    </div>
</div>