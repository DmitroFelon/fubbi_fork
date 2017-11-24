<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Outline extends Model
{
	public function project()
	{
		return $this->belongsTo(Project::class);
    }

	public function author()
	{
		return $this->belongsTo(User::class);
	}
}
