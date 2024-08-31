<?php

namespace App\Controllers\User;

use App\Models\NotificationModel;
use App\Models\TaskModel;
use App\Models\UserModel;
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
        $userModel = new UserModel();
        $data['user'] = $userModel->find(session()->get('user_id'));

        if(empty($data['user']['profile_picture'])){
            $data['user']['profile_picture'] = 'vendors/images/faces/default.png';
        }
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

    public function updateUserProfile()
    {
        $user_model = new UserModel();
        $post = $this->request->getPost();
        $user_id = session()->get('user_id');


        $user_profile_picture = $this->request->getFile('profile_picture');
        if ($user_profile_picture->isValid() && !$user_profile_picture->hasMoved()&& !$user_profile_picture->getSize() !== 0) {
            // Define a new filename to avoid conflicts
            $original_file_name = pathinfo($user_profile_picture->getName(), PATHINFO_FILENAME);
            $new_file_name = $original_file_name.'-'.substr($user_profile_picture->getRandomName(),11);

            // Move the file to the desired directory
            $filePath = $this->customConfig->file_upload_path['tasks_file_path'];
            $user_profile_picture->move($filePath, $new_file_name);
            $user_profile_picture = $filePath.'/'.$new_file_name;
        }

        $data = [
            'first_name' => $post['first_name'],
            'last_name' => $post['last_name'],
            'email' => $post['user_email'],
            'mobile' => $post['user_mobile'],
            'profile_picture' => $user_profile_picture,
        ];

        $user_model->update($user_id, $data);
        $session = \Config\Services::session();

        $session->set([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'profile_picture' => $user_profile_picture
        ]);

        return redirect()->to('user/profile');
    }
}
