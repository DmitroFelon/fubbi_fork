<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Keyword
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @mixin \Eloquent
 * @property int $id
 * @property string $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Keyword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Keyword whereText($value)
 */
class Keyword extends Model
{
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
