<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 08/11/17
 * Time: 09:38
 */

namespace App\Models\Traits\Project;

use Illuminate\Support\Facades\Log;

class ProjectStates
{
    /**
     * @var array
     */
    protected $states = [
        'created' => ['initial' => true],
        'quiz_filling',
        'keywords_filling',
        'on_manager_review',
        'processing',
        'on_client_review',
        'accepted_by_client',
        'rejected_by_client',
        'completed' => ['final' => true],
    ];

    
}