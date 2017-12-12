<div id="tab-{{$role}}"
     class="tab-pane {{(request()->input('user-role') == $role or !request()->input('user-role') and $loop->first)?'active':''}}">
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