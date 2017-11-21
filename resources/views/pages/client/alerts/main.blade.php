@extends('master')

@section('content')
    <div id="test">
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusantium alias cum, cumque dicta, ducimus
            expedita fuga minima molestiae molestias nesciunt nulla quibusdam recusandae rem, repudiandae tempora veniam
            vero vitae.
        </p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, atque debitis eius ipsa iure, magni nemo
            officiis praesentium provident quas quos, rerum sunt vero. Architecto dicta facilis nemo quos sed?</p>
    </div>


@endsection

@section('script')
    <style>
        .highlight {
            background-color: #ffae85;
        }
    </style>
    <link rel="stylesheet" href="http://assets.annotateit.org/annotator/v1.2.7/annotator.min.css">

    <script src="http://assets.annotateit.org/annotator/v1.2.7/annotator-full.min.js"></script>

    <script>
        var annotation = $('#test').annotator();
        annotation.annotator('addPlugin', 'Store', {
            prefix: '/annotations',
            loadFromSearch: {},
            urls: {
                create: '?article_id=1',
                update: '/:id/?article_id=1',
                destroy: '/:id/?article_id=1',
                search: '?article_id=1'
            }
        });
        annotation.annotator('addPlugin', 'Permissions', {
            user: {id: {{Auth::user()->id}},name: "{{ Auth::user()->name }}"},
            userString: function (user) {
                if (user && user.name) {
                    return user.name;
                }
            },
            userId: function (user) {
                if (user && user.id) {
                    return user.id;
                }
            },
            permissions: {
                'read':   [{{Auth::user()->id}}],
                'update': [{{Auth::user()->id}}],
                'delete': [{{Auth::user()->id}}],
                'admin':  [{{Auth::user()->id}}]
            },
            userAuthorize: function (action, annotation, user) {
                return ( user !== null ) ? annotation.user.id == user.id : false;
            }
        });
        annotation.annotator('addPlugin','Tags');
    </script>
@endsection