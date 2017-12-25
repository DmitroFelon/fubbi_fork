<div class="chat-user">

    @if($user->isActive())
        <span class="pull-right label label-primary">{{_i('Online')}}</span>
    @else
        <span class="pull-right label label-danger">{{_i('Offline')}}</span>
    @endif

    <div class="chat-user-name">
        <a href="#">{{$user->name}}</a>
    </div>
</div>