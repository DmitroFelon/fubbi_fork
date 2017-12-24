@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>
                {{_i('Chat')}}
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox chat-view">
                    <div class="ibox-title">
                        <small class="pull-right text-muted">Last message: Mon Jan 26 2015 - 18:39:23</small>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            {{ Form::open(['method' => 'POST', 'action' => 'MessageController@store' ]) }}
                            {{Form::hidden('conversation', $conversation)}}
                            <div class="col-md-9">
                                <div class="chat-discussion">
                                    @each('entity.chat.partials.message', $chat_messages, 'chat_message')
                                </div>
                                @include('entity.chat.partials.input')
                            </div>
                            <div class="col-md-3">
                                <div class="chat-users">
                                    <div class="users-list">
                                        @each('entity.chat.partials.participant', $participants, 'user')
                                    </div>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    {{Form::submit('Send', ['class' => 'btn btn-primary btn-lg'])}}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <style>
            .role-placeholder {
                border-radius: 50%;
                width: 1.5em;
                height: 1.5em;
                padding: 8px;
                background: #fff;
                border: 2px solid white;
                color: white;
                text-align: center;
                font: 3em Arial, sans-serif;
                line-height: 1em;
                margin: 0;
            }
        </style>
@endsection


