<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 09/11/17
 * Time: 12:33
 */

namespace App\Models\Traits\Project;


use App\Exceptions\Project\ImpossibleState;
use App\Exceptions\Project\WrongTransition;


trait States
{
    protected $states = [
        'created',
        'plan',
        'quiz',
        'keywords',
        'on_manager_review',
        'processing',
        'on_client_review',
        'accepted_by_client',
        'rejected_by_client',
        'completed',
    ];

    /**
     * @param string $state
     * @return App\Models\Project
     * @throws \Exception
     */
    public function setState($state)
    {
        try {
            $this->validateState($state);
        } catch (\Exception $e) {
            throw $e;
        }

        $this->state = $state;


        if ($this->isDirty()) {
            $this->save();
            $this->fireModelEvent('setState', false);
        }

        return $this;
    }

    public function validateState($state)
    {

        throw_unless(in_array($state, $this->states), ImpossibleState::class, 'Impossible state of project');
        throw_unless(true, WrongTransition::class, "Can't change from current state to: ".$state);
    }
}