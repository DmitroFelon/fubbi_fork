<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 02/11/17
 * Time: 17:52
 */

namespace App\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class LeftMenuComposer
 *
 * @package App\ViewComposers
 */
class LeftMenuComposer
{
	/**
	 * @var \Illuminate\Http\Request
	 */
	protected $request;

	/**
	 * @var string
	 */
	protected $page;

	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	protected $user;

	/**
	 * LeftMenuComposer constructor.
	 *
	 * @param \Illuminate\Http\Request $request
	 */
	public function __construct(Request $request)
	{
		$this->user    = Auth::user();
		$this->request = $request;
		$this->page    = $request->path();
	}

	/**
	 * @param \Illuminate\View\View $view
	 */
	public function compose(View $view)
	{

		if (Auth::check()) {
			$role  = $this->user->role;
			$links = $this->{$role}();
		} else {
			$links = $this->guest();
		}

		$view->with('items', $links);
	}

	/**
	 * @return array
	 */
	public function guest()
	{
		return [
			'Login'    => '/login',
			'Register' => '/register',
		];
	}

	/**
	 * @return array
	 */
	public function admin()
	{
		return [
			[
				'name' => 'Users',
				'url'  => '/users',
				'icon' => 'fa fa-user',
			],
			[
				'name' => 'Teams',
				'url'  => '/teams',
				'icon' => 'fa fa-users',
			],
			[
				'name' => 'Projects',
				'url'  => '/projects',
				'icon' => 'fa fa-file-o',
			],
			[
				'name' => 'Plans',
				'url'  => '/plans',
				'icon' => 'fa fa-gear',
			],
			[
				'name' => 'Meterials',
				'url'  => '/materials',
				'icon' => 'fa fa-file-word-o',
			],
			[
				'name' => 'Messages',
				'url'  => '/messages',
				'icon' => 'fa fa-envelope',
			],
			[
				'name' => 'Settings',
				'url'  => '/settings',
				'icon' => 'fa fa-gear',
			]

		];
	}

	/**
	 * @return array
	 */
	public function client()
	{
		return [
			[
				'name' => 'Projects',
				'url'  => '/projects',
				'icon' => 'fa fa-file-o',
			],
			[
				'name' => 'Messages',
				'url'  => '/messages',
				'icon' => 'fa fa-envelope',
			],
			[
				'name' => 'Settings',
				'url'  => '/settings',
				'icon' => 'fa fa-gear',
			]
		];
	}

	/**
	 * @return array
	 */
	public function account_manager()
	{
		return [
			[
				'name' => 'Teams',
				'url'  => '/teams',
				'icon' => 'fa fa-users',
			],
			[
				'name' => 'Projects',
				'url'  => '/projects',
				'icon' => 'fa fa-file-o',
			],
			[
				'name' => 'Messages',
				'url'  => '/messages',
				'icon' => 'fa fa-envelope',
			],
			[
				'name' => 'Settings',
				'url'  => '/settings',
				'icon' => 'fa fa-gear',
			]
		];
	}

	/**
	 * @return array
	 */
	public function writer()
	{
		return [
			[
				'name' => 'Projects',
				'url'  => '/projects',
				'icon' => 'fa fa-file-o',
			],
			[
				'name' => 'Messages',
				'url'  => '/messages',
				'icon' => 'fa fa-envelope',
			],
			[
				'name' => 'Settings',
				'url'  => '/settings',
				'icon' => 'fa fa-gear',
			]
		];
	}

	/**
	 * @return array
	 */
	public function editor()
	{
		return [

		];
	}

	/**
	 * @return array
	 */
	public function designer()
	{
		return [

		];
	}
}