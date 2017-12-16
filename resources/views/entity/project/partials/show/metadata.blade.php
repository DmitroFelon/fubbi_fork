<div class="panel panel-default">
    <div data-toggle="collapse" href="#meta_data" class="panel-heading clickable">
        <span class="text-center">{{_i('Project quiz result')}}</span>
        <i class="pull-right fa fa-expand" aria-hidden="true"></i>
    </div>
    <div id="meta_data" class="panel-collapse panel-body collapse">
        @foreach($project->getMeta() as $meta_key => $meta_value)
            @if($meta_value == '' or empty($meta_value) or is_object($meta_value))
                @continue
            @endif
            @if(is_array($meta_value) and !empty($meta_value))
                <div>
                    <h4>{{ title_case( str_replace('_', ' ', $meta_key)) }}</h4>
                    <ul>
                        @foreach($meta_value as $sub_key => $sub_value)
                            @isset($sub_value)
                            <li>
                                <strong>
                                    {{ (is_int($sub_key))?'':title_case( str_replace('_', ' ', $sub_key)) }}
                                </strong>
                                {!! $sub_value !!}
                            </li>
                            @endisset
                        @endforeach
                    </ul>
                </div>
            @else
                <div>
                    <strong>{{ title_case( str_replace('_', ' ', $meta_key)) }}:</strong>
                    {!!  $meta_value  !!}
                </div>
            @endif
            @if(!$loop->last)
                <hr>
            @endif

        @endforeach
    </div>
</div>