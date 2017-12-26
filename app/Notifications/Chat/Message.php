<?php

namespace App\Notifications\Chat;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;
use Musonza\Chat\Facades\ChatFacade;

class Message extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param \Musonza\Chat\Messages\Message $message
     */
    public function __construct(\Musonza\Chat\Messages\Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }


    public function toBroadcast($notifiable)
    {
        $notification               = new \stdClass();
        $notification->message      = $this->message;
        $notification->conversation = ChatFacade::conversation($this->message->conversation_id);

        $navbar_message = View::make(
            'partials.navbar-elements.message-row',
            [
                'message_notification' => $notification
            ]
        );

        $data = [
            'message_id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_name' => $this->message->sender->name,
            'sender_id' => $this->message->sender->id,
            'navbar_message' => $navbar_message->render()
        ];

        return new BroadcastMessage($data);
    }

}
