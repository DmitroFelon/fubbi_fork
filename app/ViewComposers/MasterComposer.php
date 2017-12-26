<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 01/12/17
 * Time: 10:08
 */

namespace App\ViewComposers;

use App\Models\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Musonza\Chat\Chat;
use Musonza\Chat\Messages\Message;
use Musonza\Chat\Notifications\MessageSent;

class MasterComposer
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    /**
     * @var string
     */
    protected $page;

    /**
     * TopMenuComposer constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->page    = $request->path();
        $this->user    = Auth::user();
        $this->request = $request;
    }

    public function compose(View $view)
    {
        if ($this->request->ajax()) {
            return;
        }

        if (!Auth::check()) {
            return;
        }

        $data = [
            'notifications' => $this->user->getNotifications(),
            'message_notifications' => $this->user->getMessageNotifications(),
        ];

        return $view->with($data);
    }
}