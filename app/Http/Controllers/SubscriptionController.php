<?php

namespace App\Http\Controllers;

use App\Models\Helpers\ProjectStates;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Plan;

class SubscriptionController extends Controller
{

    public function __invoke(Request $request, Project $project)
    {
        try {
            //get selected plan
            $plan = Plan::retrieve($request->input('plan_id'));

            if (!method_exists($plan->metadata, 'jsonSerialize')) {
                throw new \Exception('Plan not found');
            }

            //create subscription
            $subscription = Auth::user()
                                ->newSubscription(
                                    $request->input('project_name'),
                                    $request->input('plan_id'))
                                ->create($request->input('stripeToken'));
            //attach client id
            $project->client_id = Auth::user()->id;
            //set name
            $project->name = $request->input('project_name');
            //attach subscription
            $project->subscription_id = $subscription->id;
            //set state
            $project->setState(ProjectStates::QUIZ_FILLING);
            $project->save();

            //fill services
            $project->setServices($plan);
            //set filrst cycle
            $project->setCycle($request->input('plan_id'));

            //set quiz flag in case user will click "back" button
            Session::put('quiz', $project->id);

            return redirect()
                ->action('ProjectController@edit', [$project, 's' => ProjectStates::QUIZ_FILLING])
                ->with('success', _i('Your subscribtion has been created successfully'));

        } catch (\Exception $e) {
            redirect()->back()
                      ->with('error', _i('Something wrong happened while your subscription, please contant to administrator'));
        }
    }

}
