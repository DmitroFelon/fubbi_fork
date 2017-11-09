<?php

namespace App\Observers;

use App\Models\Project;
use App\Observers\Traits\Project\Keywords;
use App\Observers\Traits\Project\States;
use App\Observers\Traits\Project\Workers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectObserver
{
    use Keywords, Workers, States;

    protected $user;

    protected $request;

    public function __construct(Request $request)
    {
        $this->user = Auth::user();
        $this->request = $request;
    }

    public function created(Project $project)
    {
        //TODO create notification
    }

    public function updated(Project $project)
    {
        //TODO create notification
    }
}