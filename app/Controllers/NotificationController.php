<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NotificationModel;

class NotificationController extends ResourceController
{
    protected $modelName = 'App\Models\NotificationModel';
    protected $format    = 'json';

    protected $user_id;

    public function __construct()
    {
        $this->user_id = session()->get('user_id');
    }
    public function markAllAsRead()
    {
        $notificationModel = new NotificationModel();
        $updated = $notificationModel->where("user_id", $this->user_id)->set(['is_read' => 1])->update();
        $response = \Config\Services::response();
        if ($updated) {
            return ApiResponse::success("Notifications marked as read successfully.", [],200, $response);
        } else {
            return ApiResponse::error("Failed to mark notifications as read.", 400, $response);
        }
    }
}
