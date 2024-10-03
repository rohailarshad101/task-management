<?php

namespace App\Controllers;

use App\Libraries\Notification;
use App\Models\TaskFileModel;
use App\Models\TaskModel;
use App\Models\TaskUserModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use Config\CustomConfig;

class TestController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function test()
    {
        $taskModel = new TaskModel();
        $notification = new Notification();

        // Get all completed tasks
        $completedTasks = $taskModel->where('status', 'completed')->findAll();
        foreach ($completedTasks as $task) {
            $task_users = $taskModel->taskUsersArr($taskModel->getTasksRelatedUsers($task['id']));
            $task_files = $taskModel->getTasksRelatedFiles($task['id']);
            $task['responsible_persons'] = $task_users;
            $task['task_files'] = $task_files;
            $this->createNewTask($task);
        }
        echo "New Tasks Created Successfully";;
    }

    public function createNewTask($old_task_arr)
    {

        $this->db->transException(true)->transStart();
        $task_model = new TaskModel();
        $responsible_persons = $old_task_arr['responsible_persons'];
        $task_files = $old_task_arr['task_files'];
        $due_date = $old_task_arr['due_date'];
        $data = [
            'title' => $old_task_arr['title'],
            'category_id' => $old_task_arr['category_id'],
            'start_date' => getDBFormattedDate($old_task_arr['start_date']),
            'due_date' => getDBFormattedDate($due_date),
            'tags' => $old_task_arr['tags'],
            'priority' => $old_task_arr['priority'],
            'status' => "Pending",
            'repetition_frequency' => $old_task_arr['repetition_frequency'],
            'description' => $old_task_arr['description']
        ];

        $task_model->save($data);
        $task_id = $task_model->getInsertID();
        foreach ($responsible_persons as $responsible_person) {
            $task_user = new TaskUserModel;
            $task_user->save([
                "user_id" => $responsible_person['id'],
                "task_id" => $task_id
            ]);
            $message = "Task '{$data['title']}' has been reassigned to you and is due on {$due_date}.";
//            $this->insertNotitifcation($responsible_person, $message);
        }

        foreach ($task_files as $task_file) {
            $taskFileModel = new TaskFileModel();
            $taskFileModel->save([
                "task_id" => $task_id,
                "user_id" => $task_file['user_id'],
                "file_name" => $task_file['file_name'],
                "file_path" => $task_file['file_path'],
                "file_type" => $task_file['file_type'],
                "file_size" => $task_file['file_size'],
            ]);
        }

        $this->db->transComplete();
    }
}
