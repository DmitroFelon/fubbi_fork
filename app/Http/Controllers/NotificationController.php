<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

/**
 * Class NotificationController
 *
 * @package App\Http\Controllers
 */
class NotificationController extends Controller
{
	
	public function index()
	{
		return view('entity.notification.index');
	}

	public function show($id)
	{
		$notification = Auth::user()->unreadNotifications()->findOrFail($id);
		$notification->markAsRead();
		return redirect($notification->data['link']);
	}
	
	/**
	 * @param null $id
	 * @return mixed
	 */
	public function read($id = null)
	{
		if (! is_null($id)) {
			$notification = Auth::user()->notifications()->where('id', $id)->first();
			if (! is_null($notification)) {
				$notification->markAsRead();
			}
		} else {
			Auth::user()->unreadNotifications->markAsRead();
		}

		return redirect('notification');
	}

}
