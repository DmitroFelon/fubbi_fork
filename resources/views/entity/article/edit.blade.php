@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>
                    {{_i('Upload article for project "%s"', [$project->name])}}
                </h5>
                 <span class="pull-right">
                     @foreach($article->tags as $tag)
                         <span class="label label-primary m-l-xs m-r-xs">{{$tag->name}}</span>
                     @endforeach
                </span>
            </div>
            <div class="ibox-content">
                <div class="ibox-content">
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
                        {{ Form::open(['method' => 'POST', 'action' => ['Project\ArticlesController@save_social_posts', $project, $article]]) }}

                        <div class="row m-t-md">
                            <h3 class="text-center">
                                {{_i('Social posts')}}
                            </h3>
                        </div>

                        @for($i = 1; $i <= 5; $i ++)
                            {!! Form::bsText('socialposts[]', (isset($article->getMeta('socialposts')[$i-1]))?$article->getMeta('socialposts')[$i-1]:'', _i("Social Post text %d", [$i]), null, ['rows' => '3'],'textarea') !!}
                        @endfor

                        {{ Form::submit(_i('Save'), ['class' => 'btn btn-primary']) }}

                        {{ Form::close()  }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

