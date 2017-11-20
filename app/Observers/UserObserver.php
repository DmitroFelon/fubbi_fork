<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 20/11/17
 * Time: 12:45
 */

namespace App\Observers;

use App\User;

class UserObserver
{
	public function created(User $user)
	{


		//TODO notify all admins and managers
		$admin = User::find(21);

		$admin->notify(new \App\Notifications\Client\Registered($user));

	}
}