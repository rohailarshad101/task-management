<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NotificationModel;

class NotificationController extends ResourceController
{
    protected $modelName = 'App\Models\NotificationModel';
    protected $format    = 'json';

    /**
     * Mark notifications as read.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function markAsRead()
    {
        $data = $this->request->getPost();
        $notificationIds = $data['notification_ids'] ?? [];

        if (empty($notificationIds)) {
            return ApiResponse::error('No notification IDs provided.');
        }

        $notificationModel = new NotificationModel();
        $updated = $notificationModel->update($notificationIds, ['is_read' => 1]);

        if ($updated) {
            return ApiResponse::success([
                'message' => 'Notifications marked as read successfully.'
            ]);
        } else {
            return ApiResponse::error('Failed to mark notifications as read.');
        }
    }
}
