<?php

namespace App\Models;

use Acacha\Stateful\Contracts\Stateful;
use Acacha\Stateful\Traits\StatefulTrait;
use App\Models\Traits\Project\Articles;
use App\Models\Traits\Project\Keywords;
use App\Models\Traits\Project\ProjectStates;
use App\Models\Traits\Project\States;
use App\Models\Traits\Project\Teams;
use App\Models\Traits\Project\Topics;
use App\Models\Traits\Project\Workers;
use Illuminate\Database\Eloquent\Model;
use Kodeine\Metable\Metable;
use Venturecraft\Revisionable\RevisionableTrait;
use App\User;

/**
 * Class Project
 *
 * @package App\Models
 */
class Project extends Model
{
    use Keywords;
    use States;
    use Workers;
    use Teams;
    use Articles;
    use Topics;
    use RevisionableTrait;
    use Metable;

    /**
     * @const string
     */
    const CREATED = 'created';

    /**
     * @const string
     */
    const QUIZ_FILLING = 'quiz_filling';

    /**
     * @const string
     */
    const KEYWORDS_FILLING = 'keywords_filling';

    /**
     * @const string
     */
    const MANAGER_REVIEW = 'on_manager_review';

    /**
     * @const string
     */
    const PROCESSING = 'processing';

    /**
     * @const string
     */
    const CLIENT_REVIEW = 'on_client_review';

    /**
     * @const string
     */
    const ACCEPTED_BY_CLIENT = 'accepted_by_client';

    /**
     * @const string
     */
    const REJECTED_BY_CLIENT = 'rejected_by_client';

    /**
     * @const string
     */
    const COMPLETED = 'completed';

    /**
     * @var bool
     */
    protected $revisionEnabled = true;

    /**
     * @var bool
     */
    protected $revisionCleanup = true;

    /**
     * @var int
     */
    protected $historyLimit = 20;

    /**
     * @var bool
     */
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
        'setState',
    ];

    /**
     * Project constructor.
     *
     * @param array $attributes
     */
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
