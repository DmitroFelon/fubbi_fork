<?php

namespace App\Models;

use Acacha\Stateful\Contracts\Stateful;
use Acacha\Stateful\Traits\StatefulTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 *
 * @package App\Models
 */
class Project extends Model implements Stateful
{
    use StatefulTrait;

    /**
     * @var array
     */
    protected $states = [
        'created' => ['initial' => true],
        'processing',
        'errored',
        'active',
        'closed' => ['final' => true],
    ];

    /**
     * @var array
     */
    protected $transitions = [
        'create' => [
            'from' => [],
            'to' => 'created',
        ],
        'activate' => [
            'from' => 'processing',
            'to' => 'active',
        ],
        'reject' => [
            'from' => 'processing',
            'to' => 'rejected',
        ],
        'complete' => [
            'from' => 'active',
            'to' => 'completed',
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workers()
    {
        return $this->belongsToMany(User::class, 'project_worker', 'project_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function keywords()
    {
        return $this->belongsToMany(Keyword::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }
}
