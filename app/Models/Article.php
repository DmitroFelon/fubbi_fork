<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @mixin \Eloquent
 * @property int $id
 * @property string $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereText($value)
 */
class Article extends Model
{
	/**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projects()
    {
        return $this->belongsTo(Project::class);
    }

	/**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
