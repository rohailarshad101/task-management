<?php

namespace App\Controllers\User;

use App\Models\NotificationModel;
use App\Models\TaskModel;
use CodeIgniter\Controller;
use DateTime;

class UserController extends Controller
{
    protected $customConfig = '';

    public function __construct()
    {
        $this->customConfig = config('CustomConfig');
    }

    public function dashboard()
    {
        $data['task_statuses_array'] = $this->customConfig->task_statuses_array_for_user;
        $user_id = session()->get('user_id');
        // get and set user notifications
        $this->getUserTaskNotifications($user_id);
        $user_related_tasks = new TaskModel();
        $tasks = $user_related_tasks->getUserRelatedTasks($user_id);
        $task_arr  = [];
        foreach ($tasks as $task)
        {
            $task_users = $user_related_tasks->taskUsersArr($user_related_tasks->getTasksRelatedUsers($task['id']));
            $tasks_files = $user_related_tasks->getTasksRelatedFiles($task['id']);
            $task_arr[]=[
                "task_id" => $task['id'],
                "task_name" => $task['title'],
                "category_name" => $user_related_tasks->getTaskCategory($task['id']),
                "responsible_persons" => $task_users,
                "start_date" => getUserFormattedDate($task['start_date']),
                "due_date" => getUserFormattedDate($task['due_date']),
                "priority" => $task['priority'],
                "status" => $task['status'],
                "description" => $task['description'],
                "tasks_related_files" => $tasks_files
            ];
        }
        $data['tasks'] = $task_arr;
        $data['task_count'] = count($task_arr);
        return view('user/user_dashboard.php', $data);
    }

    public function profile()
    {
        $data['user_id'] = session()->get('user_id');
        $data['first_name'] = session()->get('first_name');
        $data['last_name'] = session()->get('last_name');
        $data['email'] = session()->get('email');
        $data['mobile'] = session()->get('mobile');
        return view('user/user_profile', $data);
    }

    private function getUserTaskNotifications($user_id)
    {
        // Fetch unread notifications for the logged-in user
        $notificationModel = new NotificationModel();
        $notifications = $notificationModel->where('user_id', $user_id)
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Calculate the time difference for each notification
        foreach ($notifications as &$notification) {
            $createdAt = new DateTime($notification['created_at']);
            $now = new DateTime();

            $interval = $createdAt->diff($now);

            if ($interval->days > 0) {
                $notification['time_difference'] = $interval->days . ' day' . ($interval->days > 1 ? 's' : '') . ' ago';
            } elseif ($interval->h > 0) {
                $notification['time_difference'] = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
            } elseif ($interval->i > 0) {
                $notification['time_difference'] = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
            } else {
                $notification['time_difference'] = 'just now';
            }
        }

        $session = session();
        // Pass the notifications to the view or store in session
        $session->set('notifications', $notifications);
    }
}
