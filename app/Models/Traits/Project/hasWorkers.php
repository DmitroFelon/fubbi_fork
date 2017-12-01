<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 08/11/17
 * Time: 11:30
 */

namespace App\Models\Traits\Project;

use App\User;

trait hasWorkers
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workers()
    {
        return $this->belongsToMany(User::class, 'project_worker', 'project_id', 'user_id');
    }

    public function attachWorkers($args)
    {
        $this->workers()->attach($args);
        
        $this->fireModelEvent('attachWorkers', false);
    }

    public function detachWorkers($args)
    {
        $this->workers()->detach($args);
        
        $this->fireModelEvent('detachWorkers', false);
    }

    public function syncWorkers($args)
    {
        $this->workers()->sync($args);

        $this->fireModelEvent('syncWorkers', false);
    }
}