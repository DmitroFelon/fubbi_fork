<?php

namespace App\Models;

use App\User;
use BrianFaust\Commentable\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

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
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Outline onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Outline whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Outline withAllTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Outline withAnyTags($tags, $type = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Outline withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Outline withoutTrashed()
 */
class Outline extends Model implements HasMedia
{
	use HasMediaTrait;
	use HasComments;
	use SoftDeletes;
	use HasTags;

	protected $touches = ['project'];

	protected $dates = ['deleted_at'];
	
	public function project()
	{
		return $this->belongsToMany(Project::class);
    }

	public function author()
	{
		return $this->belongsTo(User::class);
	}

	public function attachTagsHelper($tag)
	{
		$this->attachTag(Tag::findOrCreate($tag, 'service_type'));
	}
}
