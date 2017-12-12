@extends('master')

@section('before-content')

@endsection

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>
                {{$user->name}}
                <span class="label label-default pull-right">{{$user->roles()->first()->display_name}}</span>
            </h5>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <table class="table small">
                        <tbody>
                        <tr>
                            <td>
                                <strong>
                                    {{__('Phone:')}}
                                </strong>
                                {{$user->phone}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>
                                    {{__('Email:')}}
                                </strong>
                                {{$user->email}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>
                                    {{$user->projects->count()}}
                                </strong>
                                {{__('Projects')}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


@endsection