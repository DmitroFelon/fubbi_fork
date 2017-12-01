<?php

namespace App\Notifications\Team;


use App\Notifications\NotificationPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use \App\Models\Invite as Invitation;

class Invite extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invite;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Invite $invite
     */
    public function __construct(Invitation $invite)
    {
       $this->invite = $invite;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        $notification = NotificationPayload::make(
            __(
                'You have beed invited to %s',
                $this->invite->team->name
            ),
            url()->action('TeamController@show', $this->invite->team),
            get_class($this->invite->team),
	        $this->invite->team->id
        );

        return $notification->toArray();
    }
}
