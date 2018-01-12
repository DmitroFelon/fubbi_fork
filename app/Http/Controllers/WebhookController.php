<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Laravel\Cashier\Subscription;


class WebhookController extends CashierController
{
    public function handleInvoicePaymentSucceeded($payload)
    {
        Log::debug($payload);
        return ['Webhook Handled'];
    }

    public function handleInvoicePaymentFailed($payload)
    {
        Log::debug('handleInvoicePaymentSucceeded');
        return ['Webhook Handled'];
    }

    public function handleInvoicePaymentPending($payload)
    {
        Log::debug('handleInvoicePaymentSucceeded');
        return ['Webhook Handled'];
    }

    public function handleInvoiceUpcoming($payload)
    {
        $subscription_id = $payload['data']['object']['subscription'] ?? false;

        throw_unless($subscription_id, \Exception::class, 'Subscription id is not set');

        //$project = Project::where('subscription_id', $subscription_id)->first();
        $project = Project::find(11);

        if ($project) {
            $client = User::find(1);
            $client->notify(new \App\Notifications\Project\Subscription($project));
        }

        Log::debug($payload);
        return ['Webhook Handled'];
    }

    public function handleInvoiceCreated($payload)
    {
        Log::debug('handleInvoiceCreated');
        return ['Webhook Handled'];
    }
}
