<?php

namespace App\Observers;

use App\Models\Project;
use App\Observers\Traits\Project\Keywords;
use App\Observers\Traits\Project\States;
use App\Observers\Traits\Project\Workers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Musonza\Chat\Facades\ChatFacade;

/**
 * Class ProjectObserver
 *
 * @package App\Observers
 */
class ProjectObserver
{
    use States;

    /**
     * @var \App\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * ProjectObserver constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->user    = Auth::user();
        $this->request = $request;
    }

    /**
     * Called when client creates a new subscription
     *
     *
     * @param \App\Models\Project $project
     */
    public function created(Project $project)
    {
        //notify admins about new subscription
        $should_be_notified = [
            'admin' => \App\Notifications\Project\Created::class,
        ];

        //invite managers about new subscription
        $should_be_invited = [
            'account_manager',
        ];

        //send confirmation to client
        $this->user->notify(new \App\Notifications\Project\Created($project));


        foreach ($should_be_notified as $role => $model) {
            $users = User::withRole($role)->get();
            $users->each(
                function (User $user, $key) use ($project, $model) {
                    $user->notify(new $model($project));
                }
            );
        }

        foreach ($should_be_invited as $role) {
            $users = User::withRole($role)->get();
            $users->each(
                function (User $user, $key) use ($project) {
                    $user->inviteTo($project);
                }
            );
        }

        /*
         * Create chat conversation
         * */

        $participants = User::withRole('admin')->get(['id'])->pluck('id');

        $participants->push($project->client->id);

        $conversation = ChatFacade::createConversation($participants->toArray());

        $conversation->update([
            'data' => [
                'project_id' => $project->id,
                'title' => $project->name
            ]
        ]);

        $project->setMeta('conversation_id', $conversation->id);
        $project->save();
    }

    /**
     * Called when client fills the quiz and keywords
     *
     *
     * @param \App\Models\Project $project
     */
    public function filled(Project $project)
    {
        $should_be_invited = [
            'account_manager',
            'writer',
            'editor',
            'designer',
        ];

        foreach ($should_be_invited as $role) {
            $users = User::withRole($role)->get();
            $users->each(
                function (User $user, $key) use ($project) {
                    Log::debug('invitation');
                    $user->inviteTo($project);
                }
            );
        }
    }

    public function attachWorker(Project $project)
    {

        if (!isset($project->eventData['attachWorker'])) {
            return;
        }

        $worker       = $project->eventData['attachWorker'];
        $conversation = ChatFacade::conversation($project->conversation_id);
        ChatFacade::addParticipants($conversation, $worker);
    }

    public function detachWorker(Project $project)
    {
        if (!isset($project->eventData['detachWorker'])) {
            return;
        }

        $worker       = $project->eventData['detachWorker'];
        $conversation = ChatFacade::conversation($project->conversation_id);
        ChatFacade::removeParticipants($conversation, $worker);

    }
}