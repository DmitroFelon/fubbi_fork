<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function workers()
    {
        return $this->belongsToMany(User::class, 'project_worker', 'project_id', 'user_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
