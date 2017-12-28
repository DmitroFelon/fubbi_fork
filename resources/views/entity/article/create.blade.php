@extends('master')

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>
                    {{_i('Upload article for project "%s"', [$project->name])}}
                </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                {{Form::open(['id' => 'article-form', 'enctype'=>"multipart/form-data",  'role'=>'form', 'multipart', 'route'=>['project.articles.store', $project->id] ])}}
                {!! Form::bsText('title', null, _i('Title'), null, ['required'], 'text') !!}
                {!! Form::bsText('body', null, _i('Article Body'), _i('Keep empty if You will upload file to Google Docs'), ['id' => 'article-textarea'], 'textarea') !!}
                {!! Form::bsText('file', null, _i('Article File'), _i('Upload file to Google Docs'), ['multiple'], 'file') !!}
                {!! Form::bsText('tags', null,_i("Type tags here"),_i("Separate by coma or click 'enter'."), ['required', 'class'=> 'tagsinput' ]) !!}
                {{Form::submit('Upload article', ['class' => 'form-control btn btn-primary'])}}
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">

        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
        }

        document.onkeypress = stopRKey;

    </script>

@endsection