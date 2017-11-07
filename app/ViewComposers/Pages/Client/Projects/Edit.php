<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 07/11/17
 * Time: 12:00
 */

namespace App\ViewComposers\Pages\Client\Projects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class Edit
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;
    protected $user;

    /**
     * TopMenuComposer constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->user = Auth::user();
    }

    /**
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {

        $project = $this->user->projects()->where('id', $this->request->route('id'))->with('workers')->firstOrFail();

        $view->with(
            'project', $project);
    }
}