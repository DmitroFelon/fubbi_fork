<?php

namespace App\ViewComposers\Pages\Admin\Projects;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class All
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * TopMenuComposer constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {

        $client = $this->request->input('client');

        $projects = Project::with('client')->when($client, function ($query) use ($client) {
            return $query->where('client_id', $client);
        })->get();

        $view->with('projects', $projects);
    }
}