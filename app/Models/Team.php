<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function users(){
        return $this->belongsToMany(User::class,  'team_user', 'team_id', 'user_id');
    }
}
