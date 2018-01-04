@role(['client', 'admin', 'account_manager'])
    @includeIf(\App\Models\Helpers\ProjectStates::getTab($project->state))
@endrole



