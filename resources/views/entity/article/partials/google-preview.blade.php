<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <a target="_blank" class="btn btn-primary pull-right m-sm"
           href="https://docs.google.com/document/d/{{$article->google_id}}/edit">
            <strong>{{_i('See in Google Docs')}}</strong>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="description pull-right">
            {{_i('You must be logged in to Google as ')}} <br> <strong>{{Auth::user()->email}}</strong>
        </div>
        <iframe id="google-frame"
                width="100%"
                height="500"
                seamless align="middle"
                src="https://docs.google.com/document/d/{{$article->google_id}}/edit?usp=sharing&rm=minimal&embedded=true"
                frameborder="0"></iframe>
    </div>
</div>
