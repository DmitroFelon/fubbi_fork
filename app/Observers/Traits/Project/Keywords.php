<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 08/11/17
 * Time: 11:34
 */

namespace App\Observers\Traits\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use User;
use Venturecraft\Revisionable\Revision;

trait Keywords
{


    public function attachKeywords(Project $project)
    {
        $user = Auth::user();

    }

    public function detachKeywords(Project $project)
    {
        $user = Auth::user();

    }

    public function syncKeywords(Project $project)
    {
        
        $user = Auth::user();
        
    }

}