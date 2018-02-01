<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TrivecartController extends Controller
{
    public function handle(Request $request)
    {
        $hash                = $request->input('thrivecart_secret');
        $event               = $request->input('event');
        $base_product        = $request->input('base_product');
        $order_id            = $request->input('order_id');
        $customer_id         = $request->input('customer_id');
        $customer_identifier = $request->input('customer_identifier'); //stripe customer id
        $customer            = $request->input('customer'); //form data
        $order               = $request->input('order'); //form data


        Log::debug($request->getContent());

        Log::debug($request->input());

        return new Response('Webhook Handled', 200);
    }
}
