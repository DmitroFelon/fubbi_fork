<?php

namespace Musonza\Chat\Notifications;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;
use Musonza\Chat\Conversations\Conversation;
use Musonza\Chat\Messages\Message;

class MessageNotification
{
    /**
     * Creates a new notification.
     *
     * @param Message $message
     * @param Conversation $conversation
     */
    public static function make(Message $message, Conversation $conversation)
    {

        $recipients = $conversation->users->filter(function ($user) use ($message, $conversation) {
            $current_user_id = Auth::user()->id;

            if ($current_user_id == $user->id) {
                return;
            }

            return $message->user_id !== $user->id;
        });

        Notification::send($recipients, new MessageSent([
            'message_id' => $message->id,
            'conversation_id' => $conversation->id,
        ]));
    }
}
