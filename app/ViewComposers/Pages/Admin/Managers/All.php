<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 03/11/17
 * Time: 16:44
 */

namespace App\ViewComposers\Pages\Admin\Managers;

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
        $view->with('users', \App\Models\Role::where('name', 'account_manager')->first()->users()->get());
    }
}