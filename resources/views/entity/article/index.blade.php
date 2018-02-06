@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                @if(isset($project))
                    <h5> {{$project->name}} </h5>
                    <div class="ibox-tools">

                        @can('articles.create', $project)
                            <a target="_blank" href="{{url()->action('Project\ArticlesController@create', [$project])}}"
                               class="btn btn-primary btn-xs">{{_i('Create new Article')}}</a>
                        @endcan

                    </div>
                @else
                    <h5>
                        {{_i('All articles')}}
                    </h5>
                @endif
            </div>
            <div class="ibox-content">
                <div class="row m-b-sm m-t-sm">
                    @include('entity.article.partials.search')
                    @include('entity.article.partials.export')
                </div>

                <hr>
                <div class="project-list">
                    <span class="pull-right">{{_i('Count')}} : {!! $articles->total() !!} </span>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="footable-sortable">{{_i('Info')}}</th>
                            <th class="footable-sortable">{{_i('Status')}}</th>
                            <th>{{_i('Type')}}</th>
                            <th class="footable-sortable">{{_i('Rating')}}</th>
                            <th class="">{{_i('Idea')}}</th>
                            <th class="">{{_i('This month')}}</th>
                            <th class="footable-sortable" class=""></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                            @include('entity.article.partials.row')
                        @endforeach
                        </tbody>
                    </table>
                    {!! $articles->links() !!}
                </div>

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
                readOnly: ($(this).attr('data-rating-read')) ? true : false
            });
        });
    </script>
@endsection