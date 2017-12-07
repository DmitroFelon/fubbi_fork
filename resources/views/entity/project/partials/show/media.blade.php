<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div data-toggle="collapse" href="#media_collection" class="panel-heading clickable">
                <span class="text-center">{{__('Attached media files')}}</span>
                <i class="pull-right fa fa-expand" aria-hidden="true"></i>
            </div>
            <div id="media_collection" class="panel-collapse panel-body collapse">
                @foreach(\App\Models\Project::$media_collections as $collection)
                    @if(!$project->hasMedia($collection)) @continue @endif
                    <div class="row">
                        <div class="col col-xs-12">
                            <h3 class="text-center">{{title_case(str_replace('_',' ',$collection))}}</h3>
                            @each('entity.project.partials.files-row', $project->getMedia($collection), 'media', 'entity.project.partials.files-row-empty')
                        </div>

                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>