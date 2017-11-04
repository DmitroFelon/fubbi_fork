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
        $view->with('projects', Project::with('client')->get());
    }
}