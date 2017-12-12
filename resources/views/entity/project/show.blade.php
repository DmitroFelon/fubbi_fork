@extends('master')

@section('before-content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{__('Project details')}}</h2>
        </div>
    </div>

    @if(!$project->hasWorker() and \Illuminate\Support\Facades\Auth::user()->hasInvitetoProject($project->id) )
        @include('entity.project.partials.form.invite')
    @endif
@endsection

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>{{$project->name}}</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('entity.project.partials.show.head')

                {{--Metadata block start--}}

                @include('entity.project.partials.show.metadata')
                {{--Metadata block end--}}

                {{--Media block start--}}

                @include('entity.project.partials.show.media')
                {{--Media block end--}}
            </div>
        </div>
    </div>

    @role(['account_manager'])
        @include('entity.project.worker-area.writer.main')
    @endrole

    @role(['writer'])
        @include('entity.project.worker-area.writer.main')
    @endrole

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Tags:</h5>
                                <button class="btn btn-primary btn-xs" type="button">Model</button>
                                <button class="btn btn-white btn-xs" type="button">Publishing</button>
                            </div>
                            <div class="col-md-6">
                                <div class="small text-right">
                                    <h5>Stats:</h5>
                                    <div> <i class="fa fa-comments-o"> </i> 56 comments </div>
                                    <i class="fa fa-eye"> </i> 144 views
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">

                                <h2>Comments:</h2>
                                <div class="social-feed-box">
                                    <div class="social-avatar">
                                        <a href="" class="pull-left">
                                            <img alt="image" src="img/a1.jpg">
                                        </a>
                                        <div class="media-body">
                                            <a href="#">
                                                Andrew Williams
                                            </a>
                                            <small class="text-muted">Today 4:21 pm - 12.06.2014</small>
                                        </div>
                                    </div>
                                    <div class="social-body">
                                        <p>
                                            Many desktop publishing packages and web page editors now use Lorem Ipsum as their
                                            default model text, and a search for 'lorem ipsum' will uncover many web sites still
                                            default model text.
                                        </p>
                                    </div>
                                </div>
                                <div class="social-feed-box">
                                    <div class="social-avatar">
                                        <a href="" class="pull-left">
                                            <img alt="image" src="img/a2.jpg">
                                        </a>
                                        <div class="media-body">
                                            <a href="#">
                                                Michael Novek
                                            </a>
                                            <small class="text-muted">Today 4:21 pm - 12.06.2014</small>
                                        </div>
                                    </div>
                                    <div class="social-body">
                                        <p>
                                            Many desktop publishing packages and web page editors now use Lorem Ipsum as their
                                            default model text, and a search for 'lorem ipsum' will uncover many web sites still
                                            default model text, and a search for 'lorem ipsum' will uncover many web sites still
                                            in their infancy. Packages and web page editors now use Lorem Ipsum as their
                                            default model text.
                                        </p>
                                    </div>
                                </div>
                                <div class="social-feed-box">
                                    <div class="social-avatar">
                                        <a href="" class="pull-left">
                                            <img alt="image" src="img/a3.jpg">
                                        </a>
                                        <div class="media-body">
                                            <a href="#">
                                                Alice Mediater
                                            </a>
                                            <small class="text-muted">Today 4:21 pm - 12.06.2014</small>
                                        </div>
                                    </div>
                                    <div class="social-body">
                                        <p>
                                            Many desktop publishing packages and web page editors now use Lorem Ipsum as their
                                            default model text, and a search for 'lorem ipsum' will uncover many web sites still
                                            in their infancy. Packages and web page editors now use Lorem Ipsum as their
                                            default model text.
                                        </p>
                                    </div>
                                </div>
                                <div class="social-feed-box">
                                    <div class="social-avatar">
                                        <a href="" class="pull-left">
                                            <img alt="image" src="img/a5.jpg">
                                        </a>
                                        <div class="media-body">
                                            <a href="#">
                                                Monica Flex
                                            </a>
                                            <small class="text-muted">Today 4:21 pm - 12.06.2014</small>
                                        </div>
                                    </div>
                                    <div class="social-body">
                                        <p>
                                            Many desktop publishing packages and web page editors now use Lorem Ipsum as their
                                            default model text, and a search for 'lorem ipsum' will uncover many web sites still
                                            in their infancy. Packages and web page editors now use Lorem Ipsum as their
                                            default model text.
                                        </p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection