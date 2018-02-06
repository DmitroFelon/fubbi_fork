<?php

namespace App\Notifications\Worker;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class Attached
 * @package App\Notifications\Worker
 */
class Attached extends Notification
{
    use Queueable;

    /**
     * @var Project
     */
    protected $project;

    /**
     * Create a new notification instance.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You have been attached to project!')
            ->line(_i('Hello %s', [$notifiable->name]))
            ->line(_i('You have beed attached to project: "%s".', [$this->project->name]))
            ->action('Review Project', action('Resources\ProjectController@show', $this->project))
            ->line('Thank you for using our application!');
    }

}
