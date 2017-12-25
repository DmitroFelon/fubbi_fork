<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 01/12/17
 * Time: 10:08
 */

namespace App\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
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

        if (!Auth::check()) {
            return;
        }


        //mark user's message as read (Musonza\Chat bug)
        $messages = $this->user->unreadNotifications()->where('type', '=', MessageSent::class)->get();
        $messages->each(function (DatabaseNotification $notification) {
            $message = Message::find($notification->data['message_id']);
            if ($message->user_id == Auth::user()->id) {
                $message->markRead($this->user);
            }
        });

        $data = [
            'notifications' => $this->user->unreadNotifications()->where('type', '!=', MessageSent::class)->get(),
            'old_notifications' => $this->user->readNotifications()->where('type', '!=', MessageSent::class)->get(),
            'messages' => $this->user->unreadNotifications()->where('type', '=', MessageSent::class)->get(),
        ];

        return $view->with($data);
    }
}