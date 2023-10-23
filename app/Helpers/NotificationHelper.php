<?php

/**
 * Menu Helper
 *
 * Updated 31 Agustus 2021, 09:40
 *
 * @author ShalihRizal
 *
 */

namespace App\Helpers;

use Request;
use Illuminate\Support\Facades\Auth;
use Modules\Notification\Repositories\NotificationRepository;

class NotificationHelper
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public static function render()
    {
        $_notificationRepository = new NotificationRepository;

        $data = [
            'status' => '0'
        ];
        $notificationscount = $_notificationRepository->countByParams($data);

        // $countSize = count($notificationscount);

        return $notificationscount;

    }

}

