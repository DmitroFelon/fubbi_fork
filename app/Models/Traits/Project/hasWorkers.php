<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 08/11/17
 * Time: 11:30
 */

namespace App\Models\Traits\Project;

use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class hasWorkers
 *
 * attach App\User to App\Models\Project
 *
 * @package App\Models\Traits\Project
 */
trait hasWorkers
{
	/**
	 * @param $args
	 */
	public function attachWorker($args)
	{
		$this->workers()->attach($args);

		$this->fireModelEvent('attachWorkers', false);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function workers()
	{
		return $this->belongsToMany(User::class, 'project_worker', 'project_id', 'user_id');
	}

	/**
	 * @param $args
	 */
	public function detachWorker($args)
	{
		$this->workers()->detach($args);

		$this->fireModelEvent('detachWorkers', false);
	}

	/**
	 * @param $args
	 */
	public function syncWorkers($args)
	{
		$this->workers()->sync($args);

		$this->fireModelEvent('syncWorkers', false);
	}

	/**
	 * @param null $role
	 * @return bool
	 */
	public function hasWorker($role = null)
	{
		return !array_key_exists(
			(is_null($role)) ? Auth::user()->role : $role,
			$this->requireWorkers()
		);
	}

	/**
	 * @return array
	 */
	public function requireWorkers()
	{

		$required_workers = [
			'writer'          => __('Writer'),
			'designer'        => __('Designer'),
			'account_manager' => __('Account manager'),
			'editor'          => __('Editor'),
			'researcher'      => __('Researcher'),
		];

		$has_worker = [];

		$this->workers()->each(
			function (User $user, $key) use (&$has_worker, $required_workers) {
				$has_worker[$user->role] = $required_workers[$user->role];
			}
		);

		return array_diff($required_workers, $has_worker);
	}
}