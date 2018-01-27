<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/26/18
 * Time: 2:01 PM
 */

namespace App\Models\Traits\User;


use App\Models\Helpers\NotificationTypes;
use App\Models\Role;

trait hasNotificationSettings
{

    protected $project_notifications_checkboxes = [
        NotificationTypes::PROJECT_STATUS   => [
            'label'       => 'Disable project status update notification',
            'description' => '',
        ],
        NotificationTypes::PROJECT_MATERIAL => [
            'label'       => 'Disable project materials update notification',
            'description' => '',
        ],
    ];

    protected $billing_notification_checkboxes = [
        NotificationTypes::BILLING_SUCCESS => [
            'label'       => 'Disable notification about seccesfull payment',
            'description' => ''

        ],
        NotificationTypes::BILLING_REJECT  => [
            'label'       => 'Disable notification about rejected payment',
            'description' => ''
        ],
        NotificationTypes::BILLING_REMIND  => [
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
            $project_notifications_checkboxes[NotificationTypes::ARTICLE_NOT_DUE]     = [
                'label'       => _i('Item not due yet'),
                'description' => _i(' ')
            ];
            $project_notifications_checkboxes[NotificationTypes::ARTICLE_DUE_1]       = [
                'label'       => _i('Item 1 business day overdue'),
                'description' => _i(' ')
            ];
            $project_notifications_checkboxes[NotificationTypes::ARTICLE_DUE_2]       = [
                'label'       => _i('Item 2 business day overdue'),
                'description' => _i(' ')
            ];
            $project_notifications_checkboxes[NotificationTypes::ARTICLE_DISAPPROVED] = [
                'label'       => _i('Disapprovals'),
                'description' => _i(' ')
            ];
        }

        if ($this->role == Role::ADMIN) {

            $project_notifications_checkboxes[NotificationTypes::CLIENT_REGISTERED] = [
                'label'       => _i('New Clients'),
                'description' => _i(' ')
            ];

            $project_notifications_checkboxes [NotificationTypes::PROJECT_PAUSE] = [
                'label'       => _i('Account pauses'),
                'description' => _i(' ')

            ];
        }


        return $project_notifications_checkboxes;
    }
}