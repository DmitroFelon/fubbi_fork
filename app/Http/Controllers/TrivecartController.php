<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TrivecartController extends Controller
{
    public function handle(Request $request)
    {
        Log::debug($request->input());
        return new Response('Webhook Handled', 200);
        $event = $request->input('event');
        if (!'order.success' == $event) {
            return new Response('Webhook Handled', 200);
        }

        $hash                = $request->input('thrivecart_secret'); // todo check on each request
        $customer_identifier = $request->input('customer_identifier'); //stripe customer id
        $customer            = $request->input('customer'); //form data
        $order               = $request->input('order'); //array data
        $subscriptions       = collect($request->input('subscriptions')); //subscription ids, get first
        $purchases           = collect($request->input('purchases')); //product name to be validated

        $customer_email = $customer['email']??'';

        $user = User::whereEmail($customer_email)->get();
        if (!$user) {
            $user = User::create([
                'email'      => $customer_email,
                'first_name' => $customer['first_name'] ?? '',
                'last_name'  => $customer['last_name'] ?? '',
            ]);
        }


        return new Response('Webhook Handled', 200);
    }
}
