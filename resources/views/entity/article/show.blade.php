@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>
                    {{$article->title}}
                </h5>

                @role([\App\Models\Role::CLIENT])
                @if($article->accepted == null or $article->accepted == false)
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
                @role([\App\Models\Role::CLIENT])
                <div data-rating="{{$article->ratingPercent}}" class="ratable">
                </div>
                @endrole
                <div class="row">
                    @if($article->google_id)
                        @include('entity.article.partials.google-preview')
                    @endif
                </div>
                @if($article->hasMedia('copyscape'))
                    <div class="row">
                        <h3 class="text-center">
                            {{_i('Copyscape screenshot')}}
                        </h3>
                        <a target="_blank" href="{{$article->getMedia('copyscape')->first()->getFullUrl()}}">
                            <img class="img-thumbnail" width="250"
                                 src="{{$article->getMedia('copyscape')->first()->getFullUrl()}}" alt="">
                        </a>
                    </div>
                @endif
                @if(is_array($article->getMeta('socialposts')))
                    <div class="row">
                        <div class="row m-t-md">
                            <h3 class="text-center">
                                {{_i('Social posts')}}
                            </h3>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row m-t-lg">

                                @foreach($article->getMeta('socialposts') as $post)
                                    <blockquote>
                                        <p>
                                            {{$post}}
                                        </p>
                                    </blockquote>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(".ratable").each(function (item) {
            $(this).rateYo({
                rating: $(this).attr('data-rating') + "%",
                precision: 0,
                readOnly: false,
                fullStar: true
            }).on("rateyo.set", function (e, data) {
                $.post('{{action('Project\ArticlesController@rate', [$article->project, $article])}}', {
                    rate: data.rating / 20
                });
            });
        });
    </script>

@endsection