<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 05/11/17
 * Time: 10:32
 */

namespace App\ViewComposers\Pages\Client\Projects;

use App\Models\Users\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class All
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
        $client = new Client($this->user->toArray());

        $view->with(
            'projects', $client->projects()->with('workers')->get());
    }
}