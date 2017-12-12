<div id="tab-{{$role}}"
     class="tab-pane {{(request()->input('r') == $role or !request()->input('r') and $loop->first)?'active':''}}">
    <div class="full-height-scroll">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tbody>
                @each('entity.user.partials.row', $users, 'user', 'entity.user.partials.empty-row' )
                </tbody>
            </table>
        </div>
    </div>
</div>