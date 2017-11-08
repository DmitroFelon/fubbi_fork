<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 08/11/17
 * Time: 09:38
 */

namespace App\Models\Traits\Project;

trait ProjectStates
{
    /**
     * @var array
     */
    protected $states = [
        'created' => ['initial' => true],
        'keywords_filling',
        'keywords_filled',
        'on_manager_review',
        'accepted_by_manager',
        'rejected_by_manager',
        'processing',
        'on_client_review',
        'accepted_by_client',
        'rejected_by_client',
        'completed' => ['final' => true],
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
}