<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;


class WebhookController extends CashierController
{
    public function handleInvoicePaymentSucceeded($payload)
    {
        Log::debug('handleInvoicePaymentSucceeded');
        return new Response('Webhook Handled', 200);
    }

    public function handleInvoicePaymentFailed($payload)
    {
        Log::debug('handleInvoicePaymentSucceeded');
        return new Response('Webhook Handled', 200);
    }

    public function handleInvoicePaymentPending($payload)
    {
        Log::debug('handleInvoicePaymentSucceeded');
        return new Response('Webhook Handled', 200);
    }

    public function handleInvoiceUpcoming($payload)
    {
        Log::debug('handleInvoiceUpcoming');
        return new Response('Webhook Handled', 200);
    }

    public function handleInvoiceCreated($payload)
    {
        Log::debug('handleInvoiceCreated');
        return new Response('Webhook Handled', 200);
    }
}
