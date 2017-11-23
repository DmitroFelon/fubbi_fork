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
		$admins = User::withRole('admin')->get();

		$admins->each(function (User $item, $key) use ($user) {
			$item->notify(new \App\Notifications\Client\Registered($user));
		});
	}
}