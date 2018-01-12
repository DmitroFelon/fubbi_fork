<?php

namespace App\Http\Controllers;


use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;


class WebhookController extends CashierController
{
    public function handleInvoicePaymentSucceeded($payload)
    {
        Log::debug($payload);
        return ['Webhook Handled'];
    }

    public function handleInvoicePaymentFailed($payload)
    {
        return ['Webhook Handled'];
    }

    public function handleInvoicePaymentPending($payload)
    {
        return ['Webhook Handled'];
    }

    public function handleInvoiceUpcoming($payload)
    {
        $subscription_id = $payload['data']['object']['subscription'] ?? false;

        throw_unless($subscription_id, \Exception::class, 'Subscription id is not set');

        $project = Project::where('subscription_id', $subscription_id)->first();

        if ($project) {
            $client = $project->client;
            $client->notify(new \App\Notifications\Project\Subscription($project));
        }

        return ['Webhook Handled'];
    }

    public function handleInvoiceCreated($payload)
    {
        return ['Webhook Handled'];
    }
}
