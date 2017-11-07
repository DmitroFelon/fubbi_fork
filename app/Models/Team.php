<?php


namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Ghanem\Rating\Traits\Ratingable;

class Team extends Model
{
    use Ratingable;

    public function users(){
        return $this->belongsToMany(User::class,  'team_user', 'team_id', 'user_id');
    }
}
