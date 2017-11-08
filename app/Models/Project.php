<?php

namespace App\Models;

use Acacha\Stateful\Contracts\Stateful;
use Acacha\Stateful\Traits\StatefulTrait;
use App\Models\Traits\Project\Articles;
use App\Models\Traits\Project\Keywords;
use App\Models\Traits\Project\ProjectStates;
use App\Models\Traits\Project\Teams;
use App\Models\Traits\Project\Topics;
use App\Models\Traits\Project\Workers;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Project
 *
 * @package App\Models
 */
class Project extends Model implements Stateful
{
    use StatefulTrait;
    use ProjectStates;
    use Keywords;
    use Workers;
    use Teams;
    use Articles;
    use Topics;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 20;
    protected $revisionCreationsEnabled = true;

    /**
     * Additional observable events.
     */
    protected $observables = [
        'attachKeywords',
        'detachKeywords',
        'syncKeywords',
        'attachWorkers',
        'detachWorkers',
        'syncWorkers',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
