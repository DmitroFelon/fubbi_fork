<tr>
    <td class="project-status">
        <span class="label label-primary"></span>
    </td>
    <td class="project-title">
        <a href="{{action('PlanController@show', ['id' => $plan->id])}}">{{$plan->name}}</a>
        <br/>
        <small>{{$plan->id}}</small>
    </td>
    <td class="project-people">
        {{__('Amount')}}: ${{$plan->amount/100}}
    </td>
    <td class="project-people">
        {{__('Projects')}}: {{$plan->projects}}
    </td>
    <td class="project-actions">
        <a href="{{action('PlanController@show', ['id' => $plan->id])}}" class="btn btn-white btn-sm">
            <i class="fa fa-folder"></i> View
        </a>
        @role('client')
        <a href="{{action('PlanController@edit', ['id' => $plan->id])}}" class="btn btn-white btn-sm">
            <i class="fa fa-pencil"></i> Edit
        </a>
        @endrole
    </td>
</tr>