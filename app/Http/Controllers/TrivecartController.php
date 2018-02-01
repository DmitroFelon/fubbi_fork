<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Stripe\Customer;
use Stripe\Subscription;

class TrivecartController extends Controller
{
    public function handle(Request $request)
    {
        Log::debug($request->input());

        $event      = $request->input('event');
        $hash       = $request->input('thrivecart_secret'); // todo check on each request
        $product_id = $request->input('base_product'); // todo check on each request


        if ($event != 'order.success') {
            return new Response('Webhook Handled', 200);
        }

        if (!$hash) {
            return new Response('Webhook Handled', 200);
        }

        if (!$product_id) {
            return new Response('Webhook Handled', 200);
        }


        $customer_identifier = $request->input('customer_identifier'); //stripe customer id
        $customer            = $request->input('customer'); //form data
        $subscriptions       = collect($request->input('subscriptions'))->first(); //subscription ids, get first

        $customer_email = $customer['email']??'';

        $stripe_customer = Customer::retrieve($customer_identifier);

        $stripe_subscription = Subscription::retrieve($subscriptions);

        $custome_card = collect($stripe_customer->sources->data)->first();


        $user = User::whereEmail($customer_email)->get();
        if (!$user) {

            $user = User::create([
                'email'          => $customer_email,
                'first_name'     => $customer['first_name'] ?? '',
                'last_name'      => $customer['last_name'] ?? '',
                'password'       => Hash::make(str_random(8)),
                'phone'          => $customer['contactno']??'',
                'stripe_id'      => $stripe_subscription->customer,
                'trial_ends_at'  => $stripe_subscription->trial_end,
                'card_brand'     => $custome_card->brand,
                'card_last_four' => $custome_card->last4,
            ]);

            $user->setMeta('address_line_1', $custome_card->address_line1);
            $user->setMeta('zip', $custome_card->address_zip);
            $user->setMeta('city', $custome_card->address_city);
            $user->setMeta('country', $custome_card->address_country);
            $user->setMeta('state', $custome_card->address_state);

            $user->save();

            Cache::put($customer['ip_address'], $user->id, now()->addHour());
        }


        return new Response('Webhook Handled', 200);
    }
}
