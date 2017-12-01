<?php

namespace App\Notifications\Project;

use App\Models\Invite as Invitation;
use App\Notifications\NotificationPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Invite extends Notification
{
	use Queueable;

	protected $invite;

	/**
	 * Create a new notification instance.
	 *
	 * @param $project
	 */
	public function __construct(Invitation $invite)
	{
		$this->invite = $invite;
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
		return (new MailMessage)->line(
				__(
					'You have beed invited to project "%s". Please apply or decline it',
					$this->invite->invitable->getInvitableName()
				)
			)->action('Review Project', $this->invite->invitable->getInvitableUrl())->line(
				'Thank you for using our application!'
			);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		$notification = NotificationPayload::make(
			__(
				'You have beed invited to project "%s". Please apply or decline it',
				$this->invite->project->name
			),
			$this->invite->invitable->getInvitableUrl(),
			get_class($this->invite->invitable),
			$this->invite->invitable->getInvitableId
		);

		return $notification->toArray();
	}
}
