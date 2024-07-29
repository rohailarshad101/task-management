<?php

namespace App\Controllers\User;

use App\Models\TaskModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function dashboard()
    {
        $user_id = session()->get('user_id');
        $user_related_tasks = new TaskModel();
        $tasks = $user_related_tasks->getUserRelatedTasks($user_id);
        $task_arr  = [];
        foreach ($tasks as $task)
        {
            $task_users = $user_related_tasks->taskUsersArr($user_related_tasks->getTasksRelatedUsers($task['id']));
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
}
