<div class="row m-t-md">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center">{{$title}}</h3>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h4>{{_i('Questions')}}</h4>
            <div class="bg-muted p-md" style="max-height: 300px; overflow: auto">
                <div class="row">
                    @foreach(collect($questions) as $question)
                        <div class="p-xxs col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            {{$question}}
                        </div>
                    @endforeach
                    @if(collect($questions)->isEmpty())
                        <div class="text-muted">
                            Empty
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h4>{{_i('Suggestions')}}</h4>
            <div class="bg-muted p-md" style="max-height: 300px; overflow: auto">
                <div class="row">
                    @foreach(collect($questions) as $suggestion)
                        <div class="p-xxs col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            {{$suggestion}}
                        </div>
                    @endforeach
                    @if(collect($suggestions)->isEmpty())
                        <div class="text-muted">
                            Empty
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

