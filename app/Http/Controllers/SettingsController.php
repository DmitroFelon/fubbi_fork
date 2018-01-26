<?php

namespace App\Http\Controllers;

use App\Models\Helpers\NotificationTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class SettingsController
 * @package App\Http\Controllers
 */
class SettingsController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user();

        $data = [
            'project_notifications_checkboxes' => $user->getProjectNotifications(),
            'billing_notification_checkboxes'  => $user->getBillingNotifications(),
            'disabled_notifications'           => $user->disabled_notifications,
            'user'                             => $user,
        ];

        return view('entity.user.settings', $data);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $user = Auth::user();

        if ($request->input(NotificationTypes::META_NAME)) {
            $disabled_notifications = collect($request->input(NotificationTypes::META_NAME));
            $user->setMeta(NotificationTypes::META_NAME, $disabled_notifications->toArray());
        } else {
            $user->setMeta(NotificationTypes::META_NAME, []);
        }

        $user->save();

        return redirect()->back()->with(
            'success', _i('Notification options have beed saved')
        );

    }

    /**
     * @param Request $request
     * @return mixed
     */
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
