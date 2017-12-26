<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class Test extends Notification implements ShouldBroadcast
{
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $sdf = ' asd';
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
        return new BroadcastMessage([
            'invoice_id' => 'test',
            'amount' => '50',
        ]);
    }
}
