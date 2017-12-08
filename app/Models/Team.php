<?php


namespace App\Models;

use App\Models\Interfaces\Invitable;
use App\Models\Traits\hasInvite;
use App\Notifications\Team\Invite;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Ghanem\Rating\Traits\Ratingable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Team
 *
 * @property-read mixed $avg_rating
 * @property-read mixed $count_negative
 * @property-read mixed $count_positive
 * @property-read mixed $sum_rating
 * @property-read mixed $rating_percent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ghanem\Rating\Models\Rating[] $ratings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Team whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Team whereUpdatedAt($value)
 * @property int|null $owner_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Team whereOwnerId($value)
 * @property string|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Team whereDeletedAt($value)
 */
class Team extends Model implements Invitable
{
    use Ratingable;
    use hasInvite;
    use Notifiable;
    
	/**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany(User::class,  'team_user', 'team_id', 'user_id');
    }

	/**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }

	/**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

	/**
     * @return string
     */
    public function getInvitableUrl():string
    {
        return url()->action('TeamController@show', $this);
    }

	/**
     * @return mixed
     */
    public function getInvitableNotification()
    {
        return Invite::class;
    }

	/**
     * @return mixed
     */
    public function routeNotificationForMail()
    {
        return $this->owner->email;
    }

	/**
     * @return mixed
     */
    public function routeNotificationForPhone()
    {
        return $this->owner->phone;
    }
    
    
}
