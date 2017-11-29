<?php

namespace App\Notifications\Project;

use App\Notifications\NotificationPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Invite extends Notification
{
	use Queueable;

	protected $project;

	/**
	 * Create a new notification instance.
	 *
	 * @param $project
	 */
	public function __construct($project)
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
		return ['mail', 'database'];
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
			->line(__('New project "%s" has beed created.', $this->project->name))
			->action('Review Project', url()->action('ProjectController@show', $this->project))
			->line('Thank you for using our application!');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		$notification = NotificationPayload::make(__('New project "%s" has beed created. Please apply or decline it', $this->project->name), url()->action('ProjectController@show', $this->project), get_class($this->project), $this->project->id);

		return $notification->toArray();
	}
}
