@foreach($project->getMeta() as $meta_key => $meta_value)
    @if($meta_value == '' or empty($meta_value) or is_object($meta_value))
        @continue
    @endif
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse"
                       href="#collapse-{{$meta_key}}">{{ title_case( str_replace('_', ' ', $meta_key)) }}
                    </a>
                </h4>
            </div>
            <div id="collapse-{{$meta_key}}" class="panel-collapse collapse">
                <div class="p-md">

                    @if(is_array($meta_value) and !empty($meta_value))
                        <div>
                            <h4>{{ title_case( str_replace('_', ' ', $meta_key)) }}</h4>
                            <ul>
                                @foreach((array) $meta_value as $sub_key => $sub_value)
                                    @if(isset($sub_value))
                                        <li>
                                            <strong>
                                                {{ (is_int($sub_key))?'':title_case( str_replace('_', ' ', $sub_key)) }}
                                            </strong>
                                            {!! $sub_value !!}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div>
                            <strong>{{ title_case( str_replace('_', ' ', $meta_key)) }}:</strong>
                            {!! $meta_value !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach