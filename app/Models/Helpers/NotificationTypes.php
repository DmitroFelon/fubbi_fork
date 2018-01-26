<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 1/26/18
 * Time: 3:41 PM
 */

namespace App\Models\Helpers;


class NotificationTypes
{

    const META_NAME = 'disabled_notifications';

    const PROJECT_STATUS   = 'project-status';
    const PROJECT_PAUSE    = 'project-pause';
    const PROJECT_MATERIAL = 'project-material';

    const ARTICLE_NOT_DUE     = 'project-items_not_due';
    const ARTICLE_DUE_1       = 'project-items_due_1';
    const ARTICLE_DUE_2       = 'project-items_due_2';
    const ARTICLE_DISAPPROVED = 'project-article_disapproved';

    const BILLING_SUCCESS = 'billing-success';
    const BILLING_REJECT  = 'billing-reject';
    const BILLING_REMIND  = 'billing-remind';

    const CLIENT_REGISTERED = 'client-registered';

}