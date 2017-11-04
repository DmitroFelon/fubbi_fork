<?php

namespace App;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
    }
}
