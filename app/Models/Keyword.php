<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Keyword
 * @package App\Models
 */
class Keyword extends Model
{

    const TYPE_SUGGESTION = 'suggestions';
    const TYPE_QUESTION   = 'questions';

    /**
     * @var array
     */
    protected $fillable = [
        'idea_id',
        'text',
        'type',
        'accepted'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    /**
     * @param $query
     * @return Builder
     */
    public function scopeAccepted($query)
    {
        return $query->where('accepted', true);
    }

    public function scopeSuggestions($query)
    {
        return $query->where('type', self::TYPE_SUGGESTION);
    }

    public function scopeQuestions($query)
    {
        return $query->where('type', self::TYPE_QUESTION);
    }

}
