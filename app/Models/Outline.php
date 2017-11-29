<?php

namespace App\Models;

use App\User;
use BrianFaust\Commentable\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Outline extends Model implements HasMedia
{
	use HasMediaTrait;
	use HasComments;
	
	public function project()
	{
		return $this->belongsToMany(Project::class);
    }

	public function author()
	{
		return $this->belongsTo(User::class);
	}
}
