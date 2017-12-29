<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 12/26/17
 * Time: 6:42 PM
 */

namespace App\Observers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Musonza\Chat\Facades\ChatFacade;
use Musonza\Chat\Messages\Message;

class MessageObserver
{
    public function created(Message $message)
    {
        $conversation = $message->conversation;
        
        $recipients = $conversation->users->filter(function ($user) use ($message, $conversation) {
            return $message->user_id !== $user->id;
        });

        Notification::send($recipients, new \App\Notifications\Chat\Message($message));
    }

}