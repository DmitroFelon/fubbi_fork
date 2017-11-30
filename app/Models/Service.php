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
	public function task()
	{
		return $this->belongsTo(Task::class);
    }
}
