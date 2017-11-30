<?php

namespace App\Models;

use App\User;
use BrianFaust\Commentable\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

/**
 * App\Models\Outline
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $author
 * @property-read \Kalnoy\Nestedset\Collection|\BrianFaust\Commentable\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Outline whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Outline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Outline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Outline whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Outline whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Outline whereUserId($value)
 * @mixin \Eloquent
 */
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
