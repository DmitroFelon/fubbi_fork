<div class="i-checks">
    <label>
        <input
                {{($disabled_notifications->has($name))?'checked':''}}
                class="keywords-checkbox"
                type="checkbox"
                name="{{\App\Models\Helpers\NotificationTypes::META_NAME}}[{{$name}}]"
                value="true"> <i></i>
        {{$data['label']}}
    </label>
</div>
<div class="text-muted">{{$data['description']}}</div>