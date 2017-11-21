<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Annotation
 *
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property string|null $text
 * @property string|null $quote
 * @property array $permissions
 * @property array $tags
 * @property array $ranges
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation whereQuote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation whereRanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Annotation whereUserId($value)
 * @mixin \Eloquent
 */
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
