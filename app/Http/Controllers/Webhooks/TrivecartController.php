<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Helpers\ProjectStates;
use App\Models\Project;
use App\Models\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Stripe\Customer;
use Stripe\Subscription;

class TrivecartController extends Controller
{


    /**
     * @var Project
     */
    protected $project;
    /**
     * @var \Laravel\Cashier\Subscription
     */
    protected $subscription;

    public function __construct(Project $project, \Laravel\Cashier\Subscription $subscription)
    {
        $this->project      = $project;
        $this->subscription = $subscription;
    }


    public function handle(Request $request)
    {
        Log::debug($request->input());

        $event      = $request->input('event');
        $hash       = $request->input('thrivecart_secret');
        $product_id = $request->input('base_product');

        if ($event != 'order.success') {
            Log::error('wrong event: ' . $event);
            return new Response('Webhook Handled', 200);
        }

        if ($hash != config('fubbi.thrivecart_key')) {
            Log::error('wrong hash: ' . $hash);
            return new Response('Webhook Handled', 200);
        }

        if (!$product_id or !isset(config('fubbi.thrive_cart_plans')[$product_id])) {
            Log::error('wrong product_id: ' . $product_id);
            return new Response('Webhook Handled', 200);
        }

        try {
            $customer_identifier = $request->input('customer_identifier'); //stripe customer id
            $customer            = $request->input('customer'); //form data
            $subscription_id     = collect($request->input('subscriptions'))->first(); //subscription ids, get first

            $plan_id = config('fubbi.thrive_cart_plans')[$product_id];

            $customer_email = $customer['email']??'';

            $stripe_customer     = Customer::retrieve($customer_identifier);
            $stripe_subscription = Subscription::retrieve($subscription_id);
            $custome_card        = collect($stripe_customer->sources->data)->first();

            $user = User::whereEmail($customer_email)->first();
            if (!$user) {
                $tmp_password = str_random(8);
                $user         = User::create([
                    'email'          => $customer_email,
                    'first_name'     => $customer['first_name'] ?? '',
                    'last_name'      => $customer['last_name'] ?? '',
                    'password'       => Hash::make($tmp_password),
                    'phone'          => $customer['contactno']??'',
                    'stripe_id'      => $stripe_subscription->customer,
                    'trial_ends_at'  => Carbon::createFromTimestamp($stripe_subscription->trial_end),
                    'card_brand'     => $custome_card->brand,
                    'card_last_four' => $custome_card->last4,
                ]);

                $user->tmp_password = $tmp_password;
                $user->save();

                $role = Role::where('name', Role::CLIENT)->first();
                $user->attachRole($role);
                $user->setMeta('address_line_1', $custome_card->address_line1);
                $user->setMeta('zip', $custome_card->address_zip);
                $user->setMeta('city', $custome_card->address_city);
                $user->setMeta('country', $custome_card->address_country);
                $user->setMeta('state', $customer['address']['state'] ?? '');
                $user->save();
            }

            $subscription              = $this->subscription;
            $subscription->user_id     = $user->id;
            $subscription->name        = $customer['business_name'] ?? str_random(10);
            $subscription->stripe_id   = $subscription_id;
            $subscription->stripe_plan = $plan_id;
            $subscription->quantity    = 1;

            $subscription->save();

            $project                  = $this->project;
            $project->client_id       = $user->id;
            $project->subscription_id = $subscription->id;
            $project->name            = $customer['business_name'] ?? 'Project #' . strval($request->input('order_id'));
            $project->state           = ProjectStates::QUIZ_FILLING;

            $project->save();
            $project->setServices($plan_id);
            $project->setCycle($plan_id);


        } catch (\Exception $e) {
            Log::error($e);
        }

        Log::debug('TrivecartController:handle end');

        return new Response('Webhook Handled', 200);
    }
}
