<div class="form-group" id="{{$name}}-group">
    {{ Form::label($name, $label, ['class' => 'control-label']) }}
    {{ Form::text($name, $value, array_merge(['class' => $errors->has($name)?'has-error form-control ':'form-control ' ], $attributes)) }}
    <div class="text-muted">{{$description}}</div>
</div>