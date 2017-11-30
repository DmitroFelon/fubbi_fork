<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Service
 *
 * @property-read \App\Models\Task $task
 * @mixin \Eloquent
 */
class Service extends Model
{
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function task()
	{
		return $this->belongsTo(Task::class);
    }
}
