<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 08/11/17
 * Time: 11:30
 */

namespace App\Models\Traits\Project;

trait Workers
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workers()
    {
        return $this->belongsToMany(User::class, 'project_worker', 'project_id', 'user_id');
    }
}