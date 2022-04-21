<?php
/*
* NotificationController.php - Controller file
*
* This file is part of the Notification component.
*-----------------------------------------------------------------------------*/

namespace App\Exp\Components\Notification\Controllers;

use App\Exp\Support\CommonPostRequest;
use App\Exp\Base\BaseController;
use App\Exp\Components\Notification\NotificationEngine;

class NotificationController extends BaseController
{
	 /**
     * @var NotificationEngine - Notification Engine
     */
	protected $notificationEngine;

    /**
     * Constructor.
     *
     * @param NotificationEngine $notificationEngine - Notification Engine
     *-----------------------------------------------------------------------*/
    public function __construct(NotificationEngine $notificationEngine)
    {
        $this->notificationEngine = $notificationEngine;
	}
	
	/**
     * Get notification view.
     *
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function getNotificationView()
    {
        return $this->loadPublicView('notification.notification-list');
	}

	/**
     * Get Notification DataTable data.
     *
     *-----------------------------------------------------------------------*/
    public function getNotificationList()
    {
        return $this->notificationEngine->prepareNotificationList();
	}

	/**
     * Handle read all notification request.
     *
     * @param object read notification $request
     * @param string $reminderToken
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function readAllNotification()
    {
        $processReaction = $this->notificationEngine->processReadAllNotification();

        return $this->responseAction(
			$this->processResponse($processReaction, [], [], true)
		);
	}
}