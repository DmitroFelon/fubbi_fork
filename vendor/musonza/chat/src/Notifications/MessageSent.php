<?php

namespace Musonza\Chat\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\View;
use Musonza\Chat\Messages\Message;

class MessageSent extends Notification
{
    use Queueable;
    
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        
        $this->message = Message::find($this->data['message_id']);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        $data = [
            'messages_count' => $notifiable->getNewMessagesCount(),
            'message_id' => $this->data['message_id'],
            'conversation_id' => $this->data['conversation_id'],
            'sender_name' => $this->message->sender->name,
            'sender_id' => $this->message->sender->id,
            'navbar_content' => View::make('partials.navbar-elements.navbar-messages', ['message_notifications' => $notifiable->getMessageNotifications()])->render()
        ];


        return new BroadcastMessage($data);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->data;
    }
}
