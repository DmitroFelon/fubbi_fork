<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 23/11/17
 * Time: 08:40
 */

namespace App\Services;

use Illuminate\Support\Facades\Request;

class FlashMessage
{
	const SUCCESS = 'success';

	const WARNING = 'warning';

	const DANGER = 'danger';

	const INFO = 'info';

	public $message;

	public $type;

	public function __construct($message, $type)
	{
		$this->message = $message;
		$this->type    = $type;
	}

	public static function make($message, $type = 'success')
	{
		Request::session()->push('notifications', new self($message, $type));
	}

	public static function get()
	{
		$notifications = [];

		if (Request::session()->has('notifications')) {
			$notifications = Request::session()->pull('notifications');
		}

		return $notifications;
	}
}