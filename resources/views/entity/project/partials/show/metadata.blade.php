@foreach($metadata as $meta)
    @if($meta->value == '' or empty($meta->value) or is_object($meta->value))
        @continue
    @endif

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse"
                       href="#collapse-{{$meta->key}}">{{ title_case( str_replace('_', ' ', $meta->key)) }}
                    </a>
                </h4>
            </div>
            <div id="collapse-{{$meta->key}}" class="panel-collapse collapse">
                <div class="p-md">
                    @if(is_array($meta->value) and !empty($meta->value))
                        <div>
                            <ul>
                                @foreach((array) $meta->value as $sub_key => $sub_value)
                                    @if(!$sub_value)
                                        @continue
                                    @endif
                                    <li>
                                        <strong>
                                            {{ (is_int($sub_value))?'':title_case( str_replace('_', ' ', $sub_value)) }}
                                        </strong>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div>
                            {!! $meta->value !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach