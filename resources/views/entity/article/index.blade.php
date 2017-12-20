@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>
                    {{$project->name}}
                </h5>
                <div class="ibox-tools">
                    <a target="_blank" href="{{url()->action('Project\ArticlesController@create', [$project])}}"
                       class="btn btn-primary btn-xs">{{_i('Create new Article')}}</a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                            @foreach($project->articles as $article)
                                @include('entity.article.partials.row')
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

