<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
	var $fillable = ['page_id', 'text', 'quote', 'ranges', 'permissions', 'tags'];

	var $casts = [
		'ranges' => 'json',
		'permissions' => 'json',
		'tags' => 'json',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
