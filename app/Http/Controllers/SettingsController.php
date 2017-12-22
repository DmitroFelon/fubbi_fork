<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function index()
    {


        $user = Auth::user();

        $project_notifications_checkboxes = [
            'project-status' => [
                'label' => _i('Disable project status update notification'),
                'description' => _i('Email notification when someone change a project status')
            ],
            'project-material' => [
                'label' => _i('Disable project materials update notification'),
                'description' => _i('Email notification when someone upload a new meterial'),
            ],
            'project-message' => [
                'label' => _i('Disable new project messages notification'),
                'description' => _i('Email notification when someone leave a message on related project'),
            ]
        ];

        $billing_notification_checkboxes = [
            'billing-success' => [
                'label' => _i('Disable notification about seccesfull payment'),
                'description' => _i('Email notification when project paid'),

            ],
            'billing-reject' => [
                'label' => _i('Disable notification about rejected payment'),
                'description' => _i('Email notification when something wrong with payment'),
            ],
            'billing-remind' => [
                'label' => _i('Disable reminder about payment'),
                'description' => _i('Email reminder about coming payment'),
            ]
        ];

        $disabled_notifications = $user->disabled_notifications;

        $data = [
            'project_notifications_checkboxes' => $project_notifications_checkboxes,
            'billing_notification_checkboxes' => $billing_notification_checkboxes,
            'disabled_notifications' => $disabled_notifications,
            'user' => $user,
        ];

        return view('entity.user.settings', $data);
    }


    public function save(Request $request)
    {
        $user = Auth::user();

        if ($request->input('disabled_notifications')) {
            $disabled_notifications = collect($request->input('disabled_notifications'));
            $user->setMeta('disabled_notifications', $disabled_notifications->toArray());
        } else {
            $user->setMeta('disabled_notifications', []);
        }

        $user->save();

        return redirect()->back()->with(
            'success', _i('Notification options have beed saved')
        );

    }

    public function billing(Request $request)
    {
        $user = Auth::user();

        if ($request->input('stripeToken')) {
            try {
                $user->updateCard($request->input('stripeToken'));

                return redirect()->back()->with(
                    'sucess', _i('Card has been updated Successfully')
                );

            } catch (\Stripe\Error\Card $e) {
                $body  = $e->getJsonBody();
                $error = $body['error'];
                return redirect()->back()->with(
                    'error', $error['message']
                );
            }
        }
    }
}
