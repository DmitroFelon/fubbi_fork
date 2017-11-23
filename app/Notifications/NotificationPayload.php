<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 23/11/17
 * Time: 11:03
 */

namespace App\Notifications;

class NotificationPayload
{
	public $message;

	public $link;

	public $relation;

	public $relation_id;

	public function __construct(string $message, string $link, string $relation = null, int $relation_id = null)
	{
		$this->message     = $message;
		$this->link        = $link;
		$this->relation    = $relation;
		$this->relation_id = $relation_id;
	}

	public static function make(string $message, string $link, string $relation = null, int $relation_id = null)
	{
		return new self($message, $link, $relation, $relation_id);
	}

	public function toArray()
	{
		return get_object_vars($this);
	}
}