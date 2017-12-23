<a href="https://docs.google.com/document/d/{{$article->google_id}}/edit">
    <strong>{{_i('See in Google Docs')}}</strong>
</a>


<style>
    #google-frame{
        width:100%;
        height: 40vw;
    }
</style>

<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
    <iframe id="google-frame"
            seamless align="middle"
            src="https://docs.google.com/document/d/{{$article->google_id}}/edit?usp=sharing&rm=minimal&embedded=true"
            frameborder="0"></iframe>
</div>

<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
</div>


<br>
