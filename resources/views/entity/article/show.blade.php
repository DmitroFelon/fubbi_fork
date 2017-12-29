@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>
                    {{$article->title}}
                </h5>
                @foreach($article->tags as $tag)
                    <span class="label label-primary m-l-xs m-r-xs">{{$tag->name}}</span>
                @endforeach
                @role(['client'])
                @if($article->pivot->accepted == null or $article->pivot->accepted == false)
                    <div class="ibox-tools">
                        <a href="{{url()->action('Project\ArticlesController@accept', [$project, $article])}}"
                           class="btn btn-primary btn-xs">{{_i('Accept article')}}</a>
                        <a href="{{url()->action('Project\ArticlesController@decline', [$project, $article])}}"
                           class="btn btn-danger btn-xs">{{_i('Decline Article')}}</a>
                    </div>
                @endif
                @endrole
            </div>
            <div class="ibox-content">
                <div class="row">

                </div>
                <div class="row">
                    @if($article->google_id)
                        @include('entity.article.partials.google-preview')
                    @endif
                </div>

                <div class="row">
                    @if($article->body)
                        @include('entity.article.partials.body-preview')
                    @endif
                </div>



                <div class="row">

                    <div class="row m-t-md">
                        <h3 class="text-center">
                            {{_i('Social posts')}}
                        </h3>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row m-t-lg">
                            @for($i = 0; $i < 5; $i ++)
                                @isset($article->getMeta('socialposts')[$i])
                                <blockquote>
                                    <p>
                                        {{$article->getMeta('socialposts')[$i]}}
                                    </p>
                                </blockquote>
                                @endisset
                            @endfor
                        </div>
                    </div>


                </div>



            </div>
        </div>
    </div>
@endsection

