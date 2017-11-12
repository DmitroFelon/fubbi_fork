@extends('master')

@section('content')
    {!! Form::open(['method' => 'POST', 'action' => ['ProjectController@store']]) !!}

    @include('pages.client.projects.form')
    {!! Form::close() !!}
    <div class='form-group'>
        {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
    </div>
@endsection

@section('script')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        var themes_order = [];

        var tag_themes_input = $('#themes-input');

        tag_themes_input.tagsinput({
            allowDuplicates: false,
            itemValue:'text ',
            confirmKeys: [13, 44, 8],
            maxTags: 20,
            trimValue: true,
            freeInput: true,
            cancelConfirmKeysOnEmpty: true
        });
        tag_themes_input.on('itemAdded', function (event) {
            $('#themes-order-list').append('<li class="list-group-item" data-value="' + event.item + '">' + event.item + '</li>');
        });
        tag_themes_input.on('itemRemoved', function (event) {
            $('.list-group-item[data-value="' + event.item.text + '"]').remove();
        });

        $("#themes-order-list").sortable({
            axis: "y",
            toArray: 'data-value',
            placeholder: "sortable-placeholder",
            forcePlaceholderSize: true,
            opacity: 0.8,
            update: function (event, ui) {

                themes_order = $("#themes-order-list").sortable("toArray", {attribute: 'data-value'});
                tag_themes_input.tagsinput('removeAll');
                themes_order.forEach(function (element) {
                    tag_themes_input.tagsinput('add', {text: element});
                });
                tag_themes_input.tagsinput('refresh');
            }
        });

    </script>
    <style>
        .sortable-placeholder {
            background-color: rgba(128, 128, 128, 0.15);
        }
    </style>
@endsection
