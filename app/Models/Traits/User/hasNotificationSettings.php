<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/26/18
 * Time: 2:01 PM
 */

namespace App\Models\Traits\User;


use App\Models\Role;

trait hasNotificationSettings
{

    protected $project_notifications_checkboxes = [
        'project-status'   => [
            'label'       => 'Disable project status update notification',
            'description' => '',
        ],
        'project-material' => [
            'label'       => 'Disable project materials update notification',
            'description' => '',
        ],
        'project-message'  => [
            'label'       => 'Disable new project messages notification',
            'description' => '',
        ]
    ];

    protected $billing_notification_checkboxes = [
        'billing-success' => [
            'label'       => 'Disable notification about seccesfull payment',
            'description' => ''

        ],
        'billing-reject'  => [
            'label'       => 'Disable notification about rejected payment',
            'description' => ''
        ],
        'billing-remind'  => [
            'label'       => 'Disable reminder about payment',
            'description' => ''
        ]
    ];

    public function getBillingNotifications()
    {
        return $this->billing_notification_checkboxes;
    }

    public function getProjectNotifications()
    {

        $project_notifications_checkboxes = $this->project_notifications_checkboxes;

        if ($this->isWorker()) {
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

        if ($this->role == Role::ADMIN) {

            $project_notifications_checkboxes['client-registered'] = [
                'label'       => _i('New Clients'),
                'description' => _i(' ')
            ];

            $project_notifications_checkboxes ['client-pause'] = [
                'label'       => _i('Account pauses'),
                'description' => _i(' ')

            ];
        }


        return $project_notifications_checkboxes;
    }


}