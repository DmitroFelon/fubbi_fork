<div class="file-box">
    <div class="file">
        <span class="corner"></span>
        <div class="icon">
            @if($media->mime_type == 'image/jpeg' or $media->mime_type == 'image/png')
                <a href="{{url(str_replace('//', '', $media->getFullUrl()))}}"
                   target="_blank"
                   data-gallery="{{$media->collection_name}}">
                    <img class="blueimp-gallery-image"
                         src="{{url(str_replace('//', '', $media->getFullUrl()))}}">
                </a>
            @else
                <a target="_blank" href="{{url(str_replace('//', '', $media->getFullUrl()))}}">
                    <i class="fa fa-file"></i>
                </a>
            @endif
        </div>
        <div class="file-name">
            <a target="_blank" href="{{url(str_replace('//', '', $media->getFullUrl()))}}">
                {{$media->file_name}}
            </a>
            <br/>
            <small>Added: {{$media->created_at->format('Y-m-d')}}</small>
        </div>
    </div>
</div>