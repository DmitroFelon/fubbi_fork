<div class="form-group" id="{{$name}}-group">
    {{ Form::label($name, $label, ['class' => 'control-label']) }}
    {{ Form::text($name, $value, array_merge(['class' => 'form-control ' . $errors->has($name)?'has-error':''], $attributes)) }}
    <div class="text-muted">{{$description}}</div>
</div>