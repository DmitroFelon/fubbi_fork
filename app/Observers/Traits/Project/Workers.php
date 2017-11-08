<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 08/11/17
 * Time: 11:37
 */

namespace App\Observers\Traits\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

trait Workers
{
    public function attachWorkers(Project $project)
    {
        $user = Auth::user();

    }

    public function detachWorkers(Project $project)
    {
        $user = Auth::user();

    }

    public function syncWorkers(Project $project)
    {
        $user = Auth::user();

    }
}