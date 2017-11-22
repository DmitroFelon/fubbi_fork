<?php

namespace App\Notifications\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class Registered extends Notification implements ShouldQueue
{
	use Queueable;

	protected $new_user;

	/**
	 * Create a new notification instance.
	 *
	 */
	public function __construct($new_user)
	{
		$this->new_user = $new_user;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['database', 'mail'];
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
			->line('The introduction to the notification.')
			->action('See new client', url('/users/'.$this->new_user->id))
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
		return [
			'id'    => $this->new_user->id,
			'name'  => $this->new_user->name,
			'email' => $this->new_user->email,
		];
	}
}
