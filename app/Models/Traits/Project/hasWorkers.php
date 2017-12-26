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

    public $eventData = [];

    /**
     * @param $worker_id
     */
    public function attachWorker($worker_id)
    {
        $this->workers()->attach($worker_id);

        $this->eventData['attachWorker'] = $worker_id;

        $this->fireModelEvent('attachWorker', false);
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
    public function detachWorker($worker_id)
    {
        $this->workers()->detach($worker_id);

        $this->eventData['detachWorker'] = $worker_id;

        $this->fireModelEvent('detachWorker', false);
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
            'writer' => _i('Writer'),
            'designer' => _i('Designer'),
            'account_manager' => _i('Account manager'),
            'editor' => _i('Editor'),
            'researcher' => _i('Researcher'),
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