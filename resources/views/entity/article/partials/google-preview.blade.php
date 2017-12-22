<a href="https://docs.google.com/document/d/{{$article->google_id}}/edit">
    <strong>{{_i('See in Google Docs')}}</strong>
</a>
<embed src="{{url(str_replace('//', '', $article->export(\App\Services\Google\Drive::PDF)->getFullUrl()))}}"
       width="100%"
       height="450">