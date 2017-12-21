<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Laravel\Cashier\Subscription;

class WebhookController extends CashierController
{
    public function handleInvoicePaymentSucceeded($payload)
    {
        Log::debug('handleInvoicePaymentSucceeded');
        return ['ok'];
    }

    public function handleInvoiceUpcoming($payload)
    {
        Log::debug('handleInvoiceUpcoming');
        return ['ok'];
    }

    public function handleInvoiceCreated($payload)
    {
        Log::debug('handleInvoiceCreated');
        return ['ok'];
    }
}
