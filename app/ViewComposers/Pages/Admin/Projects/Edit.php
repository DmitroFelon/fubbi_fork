<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 03/11/17
 * Time: 16:45
 */

namespace App\ViewComposers\Pages\Admin\Projects;

use Illuminate\Http\Request;
use Illuminate\View\View;

class Edit
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
        $view->with('items', []);
    }
}