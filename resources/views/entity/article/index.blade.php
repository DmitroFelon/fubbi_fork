@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                @if(!isset($all))
                    <h5> {{$project->name}} </h5>
                    <div class="ibox-tools">
                        <a target="_blank" href="{{url()->action('Project\ArticlesController@create', [$project])}}"
                           class="btn btn-primary btn-xs">{{_i('Create new Article')}}</a>
                    </div>
                @else
                    <h5>
                        {{_i('All articles')}}
                    </h5>
                @endif
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                            @if(!isset($all))
                                @foreach($project->articles as $article)
                                    @include('entity.article.partials.row')
                                @endforeach
                            @else
                                @foreach($articles as $article)
                                    @include('entity.article.partials.row')
                                @endforeach

                            @endif
                            </tbody>
                        </table>
                        @isset($articles)
                        {{$articles->links()}}
                        @endisset

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

