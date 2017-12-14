<div class="row">
    @foreach ($plan->metadata->split(2) as $chunk)
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <table class="m-b-md">
                @foreach ($chunk as $key => $value)
                    <tr>
                        <th>
                            <label for="{{$key}}">
                                {{ucwords( str_replace('_',' ',$key) )}}
                            </label>
                        </th>
                        <td>
                            @if($value == 'true' or $value == 'false')
                                <input type="hidden" name="{{$key}}" value="false">
                                <div class="i-checks">
                                    <label>
                                        <input
                                                type="checkbox"
                                                name="{{$key}}"
                                                value="true"
                                                {{($value == 'true')?'checked="checked"':''}}> <i></i>
                                    </label>
                                </div>
                            @else
                                <input class="form-control" id="{{$key}}" name="{{$key}}"
                                       value="{{$value}}">
                            @endif
                            <small>
                                {{__('Default value: %s', $project->plan->metadata->$key)}}
                            </small>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
</div>
<div class="row">
    {!! Form::submit('Update', ['class'=>'']) !!}
</div>