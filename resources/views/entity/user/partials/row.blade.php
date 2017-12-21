<tr>
    <td class="client-avatar"><i class="fa fa-user fa-2x"></i></td>
    <td>
        <a target="_blank"
           href="{{url()->action('UserController@show', $user)}}">
            {{$user->name}}
        </a>
    </td>
    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
    <td> {{$user->email}}</td>
    <td class="contact-type"><i class="fa fa-phone"> </i></td>
    <td> {{$user->phone}}</td>
    <td class="contact-type"><i class="fa fa-file-o"></i></td>
    @if($user->projects->count())
        <td><strong>{{_i('Projects count')}}</strong>{{$user->projects->count()}}</td>
    @else
        <td></td>
    @endif


</tr>