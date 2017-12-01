<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 01/12/17
 * Time: 10:08
 */

namespace App\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MasterComposer
{
	/**
	 * @var \Illuminate\Http\Request
	 */
	protected $request;

	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	protected $user;

	/**
	 * @var string
	 */
	protected $page;

	/**
	 * TopMenuComposer constructor.
	 *
	 * @param \Illuminate\Http\Request $request
	 */
	public function __construct(Request $request)
	{
		$this->page = $request->path();
		$this->user = Auth::user();
		$this->request = $request;
	}

	public function compose(View $view){

		if(!Auth::check()){
			return;
		}

		$data = [
			'notifications' => $this->user->unreadNotifications,
			'old_notifications' => $this->user->readNotifications,
			'messages' => []
		];

		return $view->with($data);
	}
}