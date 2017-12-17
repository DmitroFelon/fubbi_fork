@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{__('plans')}}</h2>
        </div>
    </div>

@endsection

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{__('')}}</h5>
            <div class="ibox-tools">
                <a target="_blank" href="{{url()->action('PlanController@edit', $plan->id)}}"
                   class="btn btn-primary btn-xs">{{__('Edit plan')}}</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="project-list">
                {!! Form::open(['action' => ['PlanController@update', $plan->id], 'method' => 'put']) !!}
                <div class="row">
                    @foreach ($plan->meta->split(2) as $chunk)
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <table class="m-b-md">
                                @foreach ($chunk as $key => $value)
                                    <tr>
                                        <th>
                                            <label for="{{$key}}">
                                                {{ucwords( str_replace('_',' ',$key) )}}
                                            </label>
                                        </th>
                                        <td>
                                            @if($value == 'true' or $value == 'false')
                                                <input type="hidden" name="{{$key}}" value="false">
                                                <div class="i-checks">
                                                    <label>
                                                        <input
                                                                type="checkbox"
                                                                name="{{$key}}"
                                                                value="true"
                                                                {{($value == 'true')?'checked="checked"':''}}> <i></i>
                                                    </label>
                                                </div>
                                            @else
                                                <input class="form-control" id="{{$key}}" name="{{$key}}"
                                                       value="{{$value}}">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    {!! Form::submit('Update') !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection