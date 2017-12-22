<div class="i-checks">
    <label>
        <input
                {{($disabled_notifications->has($name))?'checked':''}}
                class="keywords-checkbox"
                type="checkbox"
                name="disabled_notifications[{{$name}}]"
                value="true"> <i></i>
        {{$data['label']}}
    </label>
</div>
<div class="text-muted">{{$data['description']}}</div>