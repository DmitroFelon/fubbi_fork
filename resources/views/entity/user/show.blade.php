@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Profile</h2>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
@endsection

@section('content')
    <div class="row m-b-lg m-t-lg">
        <div class="col-md-6">
            <div class="profile-info">
                <div class="">
                    <div>
                        <h2 class="no-margins">
                            {{$user->name}}
                            <small>
                                <span class="label label-default pull-right">{{$user->roles()->first()->display_name}}</span>
                            </small>
                        </h2>
                        <br>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <table class="table small m-b-xs">
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
            </div>
        </div>

@endsection