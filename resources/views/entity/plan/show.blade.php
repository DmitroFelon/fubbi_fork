@extends('master')


@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ucfirst($plan->name)}}</h5>
            <div class="ibox-tools">
                <a target="_blank" href="{{url()->action('PlanController@edit', $plan->id)}}"
                   class="btn btn-primary btn-xs">{{__('Edit plan')}}</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="">
                <div class="row">
                    @foreach ($plan->meta->split(2) as $chunk)
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <table class="m-b-md">
                                @foreach ($chunk as $key => $value)
                                    <tr>
                                        <th>
                                            {{ ucwords( str_replace('_',' ',$key) ) }}:
                                        </th>
                                        <td>
                                            @if($value == 'true')
                                                {{__('Yes')}}
                                            @elseif($value == 'false')
                                                {{__('No')}}
                                            @else
                                                {{$value}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h5>{{__('Projects with this plan')}}</h5>
                        <ul>
                            @foreach($plan->projects as $project)
                                <li>
                                    <a target="_blank" href="{{url()->action('ProjectController@show', $project)}}">
                                        {{$project->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection