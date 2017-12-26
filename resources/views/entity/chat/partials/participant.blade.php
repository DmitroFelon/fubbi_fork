<div class="chat-user">

    <span data-user-id="{{$user->id}}"  class="chat-user-status pull-right label label-danger">
        {{($user->isActive())?'Online':'Offline'}}
    </span>

    <div class="chat-user-name">
        <a href="#">{{$user->name}}</a>
    </div>
</div>