<?php

namespace App\Http\Controllers;

use App\Models\Role;
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

        $project_notifications_checkboxes = [
            'project-status'   => [
                'label'       => _i('Disable project status update notification'),
                'description' => _i(''),
            ],
            'project-material' => [
                'label'       => _i('Disable project materials update notification'),
                'description' => _i(''),
            ],
            'project-message'  => [
                'label'       => _i('Disable new project messages notification'),
                'description' => _i(''),
            ]
        ];

        $billing_notification_checkboxes = [
            'billing-success' => [
                'label'       => _i('Disable notification about seccesfull payment'),
                'description' => _i(''),

            ],
            'billing-reject'  => [
                'label'       => _i('Disable notification about rejected payment'),
                'description' => _i(''),
            ],
            'billing-remind'  => [
                'label'       => _i('Disable reminder about payment'),
                'description' => _i(''),
            ]
        ];

        $disabled_notifications = $user->disabled_notifications;

        if ($user->isWorker()) {
            $project_notifications_checkboxes['project-items_not_due']       = [
                'label'       => _i('Item not due yet'),
                'description' => _i(' ')
            ];
            $project_notifications_checkboxes['project-items_due_1']         = [
                'label'       => _i('Item 1 business day overdue'),
                'description' => _i(' ')
            ];
            $project_notifications_checkboxes['project-items_due_2']         = [
                'label'       => _i('Item 2 business day overdue'),
                'description' => _i(' ')
            ];
            $project_notifications_checkboxes['project-article_disapproved'] = [
                'label'       => _i('Disapprovals'),
                'description' => _i(' ')
            ];
        }

        if ($user->role == Role::ADMIN) {

            $project_notifications_checkboxes['client-registered'] = [
                'label'       => _i('New Clients'),
                'description' => _i(' ')
            ];

            $project_notifications_checkboxes ['client-pause'] = [
                'label'       => _i('Account pauses'),
                'description' => _i(' ')

            ];
        }


        $data = [
            'project_notifications_checkboxes' => $project_notifications_checkboxes,
            'billing_notification_checkboxes'  => $billing_notification_checkboxes,
            'disabled_notifications'           => $disabled_notifications,
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
