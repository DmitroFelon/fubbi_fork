<?php

namespace App\Jobs\Project;

use App\Models\Helpers\ProjectStates;
use App\Models\Project;
use App\Notifications\Project\Remind;
use App\Notifications\Project\Subscription;
use App\Notifications\Worker\Progress;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

/**
 * Class CheckState
 * @package App\Jobs\Project
 */
class CheckState implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Project
     */
    protected $project;

    /**
     * Create a new job instance.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        //todo run every day at 8am - 9am with cron
        //todo use with php artisan queue:listen (instead of work)

        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('start');
        //check is not project ready for workers
        if ($this->filling()) {
            //return;
        }

        //check the working progress
        $this->progress();
        //check ends_at of project subscription
        $this->subscription();
    }

    /**
     *
     */
    public function filling()
    {

        $filling_states = [
            ProjectStates::QUIZ_FILLING,
            ProjectStates::KEYWORDS_FILLING
        ];

        Log::debug($this->project->client->name . ' filling reminder start');

        if ($this->project->created_at->diffInDays(now()) > 1 and in_array($this->project->state, $filling_states)) {
            //todo remind client to complete quiz

            Log::debug($this->project->client->name . ' filling reminder');
            return;

            $this->project->client->notify(new Remind($this->project));

            return true;
        }
    }

    /**
     *
     */
    public function subscription()
    {
        $end_at_timestamp = \Stripe\Subscription::retrieve($this->project->subscription->stripe_id)->current_period_end;

        $end_at = \Carbon\Carbon::createFromTimestamp($end_at_timestamp);

        if ($end_at->diffInDays(now()) == 1) {
            //todo notify user about new billing cycle

            Log::debug($this->project->client->name . ' subscription reminder');
            return;

            $this->project->client->notify(new Subscription($this->project));

            return true;
        }

    }

    /**
     *
     */
    public function progress()
    {
        if ($this->project->created_at->diffInDays(now()) > 15 and $this->project->getProgress() < 100) {
            //todo notify workers about progress

            $this->project->workers->each(function (User $user) {
                //todo check for user's notification settings
                Log::debug($user->name . ' progress reminder');
                return;
                $user->notify(new Progress($this->project));
            });
        }
    }
}
