@include('partials.errors')
<div class="">
    <ul class="nav nav-tabs">
        <li class="">
            <a href="#plan-wrapper" data-toggle="tab">Plan</a>
        </li>
        <li class="active">
            <a href="#quiz-wrapper" data-toggle="tab">Quiz</a>
        </li>
        <li class="">
            <a href="#keywords-wrapper" data-toggle="tab">Keywords</a>
        </li>
    </ul>
    <div class="tab-content clearfix">
        <div class="tab tab-pane" id="plan-wrapper">
            @include('pages.client.projects.tabs.plan')
        </div>
        <div class="tab tab-pane active" id="quiz-wrapper">
            @include('pages.client.projects.tabs.quiz')
        </div>
        <div class="tab tab-pane" id="keywords-wrapper">
            @include('pages.client.projects.tabs.keywords')
        </div>
    </div>
</div>
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
        var tag_themes_input = $('#themes');
        tag_themes_input.on('itemAdded', function (event) {
            $("#themes-order-list-wrapper").removeClass('hide');
            $('#themes-order-list').append('<li class="list-group-item" data-value="' + event.item + '">' + event.item + '</li>');
        });
        tag_themes_input.on('itemRemoved', function (event) {
            $('.list-group-item[data-value="' + event.item + '"]').remove();
            if(tag_themes_input.val() == ''){
                $("#themes-order-list-wrapper").addClass('hide');
            }
        });
        $("#themes-order-list").sortable({
            axis: "y",
            toArray: 'data-value',
            placeholder: "sortable-placeholder",
            forcePlaceholderSize: true,
            opacity: 0.8
        });
        $(".has-error").on('click', function(){$(this).removeClass("has-error")});
        $("input").on('keydown', function(event){
            if (event.keyCode == 13) {return false}
        })
    </script>
    <style>
        .sortable-placeholder {
            background-color: rgba(128, 128, 128, 0.15);
        }
        .bootstrap-tagsinput{
            display: block;
        }
        .has-error{
            border-color: rgba(247, 53, 53, 0.8);
            box-shadow: 0 1px 1px rgba(195, 63, 63, 0.44) inset, 0 0 8px rgba(193, 25, 25, 0.83);
            outline: 0 none;
        }
        /*.bootstrap-tagsinput.focus{
            border-color: #66afe9;
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
        }*/
    </style>
@endsection